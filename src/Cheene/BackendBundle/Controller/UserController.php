<?php

namespace Cheene\BackendBundle\Controller;

use MongoDB\Driver\Exception\DuplicateKeyException;
use Cheene\UserBundle\Annotation\FrontendAccessible;
use Cheene\UserBundle\Entity\Repository\UserRepository;
use Cheene\UserBundle\Entity\User;
use Cheene\UserBundle\Entity\Constants\UserConstants;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cheene\UserBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * User controller.
 *
 * @Route("/")
 */
class UserController extends Controller
{
    /**
     * User listing.
     *
     * @Route("/", name="backend_user_index")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $datatable = $this->get('user_datatables');
        $datatable->buildDatatable();

        return array(
            'datatable' => $datatable,
        );
    }

    /**
     * Get all User entities.
     *
     * @Route("/results", name="backend_user_results", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('user_datatables');
        $datatable->buildDatatable();

        $datatableQuery = $this->get("sg_datatables.query")->getQueryFrom($datatable);
        $qb = $datatableQuery->getQuery();
        $qb->andWhere("users.deleted = '0'");
        $datatableQuery->setQuery($qb);
        return $datatableQuery->getResponse();
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="backend_user_create_new")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $newUser = new User();
        $form = $this->createNewUserForm($newUser);
        return array(
            'entity' => $newUser,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/", name="backend_user_create")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("POST")
     * @Template("CheeneBackendBundle:User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        /** @var UserRepository $userModel */
        $em = $this->getDoctrine()->getManager();
        $userModel = $em->getRepository('CheeneUserBundle:User');
        $newUser = $userModel->newUser();

        $form = $this->createNewUserForm($newUser);
        $form->handleRequest($request);

        $username = $form->getData()->getUsername();
        $email = $form->getData()->getEmail();
        $national_code = $form->getData()->getNationalCode();
        $cellphone = $form->getData()->getCellphone();

        if ($userModel->isEmailExists($email)) {
            return new JsonResponse('This Email address already exists');
        }

        if ($userModel->isUsernameExists($username)) {
            return new JsonResponse('This Username already exists');
        }
        
        if ($userModel->isCellphoneAlreadyExist($cellphone)) {
            return new JsonResponse('This cellphone number already exists');
        }
        
        if ($userModel->isNationalCodeExist($national_code)) {
            return new JsonResponse('this national code already exists');
        }

        if ($form->isValid()) {
            $altGeorgianDate = $form->getData()->getJalaliBirthday();
            $rd = new \DateTime(date("c", intval(strtotime($altGeorgianDate))));
            $userEntity = new User();
            $userEntity->setUsername($username);
            $userEntity->setSalt($form->getData()->getSalt());
            $userEntity->setEmail($email);
            $userEntity->setPlainPassword($form->getData()->getPlainPassword());
            $userEntity->setType($form->getData()->getType());
            $userEntity->setStatus($form->getData()->getStatus());
            $userEntity->setFirstname($form->getData()->getFirstname());
            $userEntity->setLastname($form->getData()->getLastname());
            $userEntity->setCellphone($cellphone);
            $userEntity->setSex($form->getData()->getSex());
            $userEntity->setComment($form->getData()->getComment());
            $userEntity->setBirthday($rd);
            $userEntity->setGlobal($form->getData()->getGlobal());
            $userEntity->setVisible($form->getData()->getVisible());
            $userEntity->setLocale($form->getData()->getLocale());
            $userEntity->setProfileImage($form->getData()->getProfileImage());
            $userEntity->setImageConfirmed($form->getData()->getImageConfirmed());
            $userEntity->setNationalCode($national_code);
            $userModel->save($userEntity);
            $em->flush();
            return $this->redirect($this->generateUrl('backend_user_index'));
        }
        return array(
            'entity' => $newUser,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $user
     * @return \Symfony\Component\Form\Form The form
     * @internal param User $entity The entity
     *
     */
    private function createNewUserForm(User $user)
    {
        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('backend_user_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'button.submit', 'translation_domain' => 'buttons', 'attr' => array(
            'class' => 'btn blue',
        )));

        return $form;
    }


    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="backend_user_edit", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('CheeneUserBundle:User')->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $editForm = $this->createEditForm($user);
        return array(
            'user_id' => $id,
            'edit_form' => $editForm->createView(),
            'user' => $user,
        );
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param User $user
     * @return \Symfony\Component\Form\Form The form
     *
     */
    private function createEditForm(User $user)
    {
        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('backend_user_update', array('id' => $user->getId())),
            'method' => 'PUT',
        )); 
        $form->add('submit', 'submit', array(
            'label' => 'button.update', 'translation_domain' => 'buttons',
            'attr' => array(
                'class' => 'btn green',
            )
        ));
        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="backend_user_update")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("PUT")
     * @Template("CheeneBackendBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        /** @var UserRepository $userModel */
        $em = $this->getDoctrine()->getManager();
        $userModel = $em->getRepository('CheeneUserBundle:User');
        $user = $userModel->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($user);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $form = $editForm;
            $altGeorgianDate = $form->getData()->getJalaliBirthday();
            $rd = new \DateTime(date("c", intval(strtotime($altGeorgianDate))));
            $user->setUsername($form->getData()->getUsername());
            $user->setSalt($form->getData()->getSalt());
            $user->setEmail($form->getData()->getEmail());
            $user->setPlainPassword($form->getData()->getPlainPassword());
            $user->setType($form->getData()->getType());
            $user->setStatus($form->getData()->getStatus());
            $user->setFirstname($form->getData()->getFirstname());
            $user->setLastname($form->getData()->getLastname());
            $user->setCellphone($form->getData()->getCellphone());
            $user->setSex($form->getData()->getSex());
            $user->setComment($form->getData()->getComment());
            $user->setBirthday($rd);
            $user->setGlobal($form->getData()->getGlobal());
            $user->setVisible($form->getData()->getVisible());
            $user->setLocale($form->getData()->getLocale());
            $user->setProfileImage($form->getData()->getProfileImage());
            $user->setImageConfirmed($form->getData()->getImageConfirmed());
            $user->setNationalCode($form->getData()->getNationalCode());
            $userModel->save($user);
            $em->flush();
            return $this->redirect($this->generateUrl('backend_user_index'));
        }

        return array(
            'entity' => $user,
            'edit_form' => $editForm->createView(),
            'user' => $user,
        );
    }


    /**
     * Edits roles of an existing User entity.
     *
     * @Route("/{id}/role/edit", name="backend_user_role_edit", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Template("CheeneBackendBundle:User:roleEdit.html.twig")
     */
    public function roleEditAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('CheeneUserBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $edit_form = $this->createRoleForm($user);

        if ($request->getMethod() == "PUT") {

            $edit_form->handleRequest($request);

            if ($edit_form->isValid()) {
                $em->flush();
            }

        }

        return array(
            'edit_form' => $edit_form->createView(),
        );
    }

    /**
     * Creates a form to edit roles of an User entity.
     *
     * @param User $user
     * @return \Symfony\Component\Form\Form The form
     * @internal param User $entity The entity
     *
     */
    private function createRoleForm(User $user)
    {

        $form = $this->createFormBuilder($user)
            ->setAction($this->generateUrl('backend_user_role_edit', array('id' => $user->getId())))
            ->setMethod('PUT')
            ->add('type', 'choice', array(
                    'choices' => UserConstants::$user_types,
                    'label' => 'label.type',
                    'translation_domain' => 'labels',
                )
            )
            ->add('roles', null, array(
                    'label' => 'label.roles',
                    'translation_domain' => 'labels',
                    'property' => 'title',
                    'expanded' => true,
                    'multiple' => true
                )
            )
            ->getForm();

        return $form;
    }

    /**
     * Query users to find a user ID by username , fullname or email
     *
     * AJAX Request
     * JSON Response
     *
     * @Route("/find-user/{_query}", name="backend_user_find", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     */
    public function findUsersAction($_query)
    {
        $em = $this->getDoctrine()->getManager();

        $userModel = $em->getRepository('CheeneUserBundle:User');
        $users = $userModel->searchForUser($_query);

        return new JsonResponse($users);
    }


}
