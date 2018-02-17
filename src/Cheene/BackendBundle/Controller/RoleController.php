<?php

namespace Cheene\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cheene\UserBundle\Entity\Role;
use Cheene\UserBundle\Form\Type\RoleType;
use Cheene\UserBundle\Annotation\FrontendAccessible;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Role controller.
 *
 * @Route("/")
 */
class RoleController extends Controller
{
    /**
     * Lists all Role entities.
     *
     * @Route("/", name="backend_role_index")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $roleDatatable = $this->get("role_datatables");
        $roleDatatable->buildDatatable();

        return array(
            "datatable" => $roleDatatable,
        );
    }

    /**
     * Get all Role entities.
     *
     * @Route("/results", name="backend_role_results", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resultsAction()
    {
        $datatable = $this->get('role_datatables');
        $datatable->buildDatatable();

        $datatableQuery = $this->get("sg_datatables.query")->getQueryFrom($datatable);
        $qb = $datatableQuery->getQuery();
        return $datatableQuery->getResponse();
    }

    /**
     * Creates a new Role entity.
     *
     * @Route("/", name="backend_role_create")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("POST")
     * @Template("CheeneBackendBundle:Role:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Role();
        $form = $this->createNewRole($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_role_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Role entity.
     *
     * @param Role $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createNewRole(Role $entity)
    {
        $form = $this->createForm(new RoleType(), $entity, array(
            'action' => $this->generateUrl('backend_role_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'label.submit', 'translation_domain' => 'labels', 'attr' => array(
            'class' => 'btn blue',
        )));

        return $form;
    }

    /**
     * Displays a form to create a new Role entity.
     *
     * @Route("/new", name="backend_role_new")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Role();
        $form   = $this->createNewRole($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Role entity.
     *
     * @Route("/{id}", name="backend_role_show", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheeneUserBundle:Role')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Role entity.
     *
     * @Route("/{id}/edit", name="backend_role_edit", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheeneUserBundle:Role')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Role entity.
    *
    * @param Role $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Role $entity)
    {
        $form = $this->createForm(new RoleType(), $entity, array(
            'action' => $this->generateUrl('backend_role_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'label.update', 'translation_domain' => 'labels', 'attr' => array(
            'class' => 'btn blue',
        )));

        return $form;
    }
    /**
     * Edits an existing Role entity.
     *
     * @Route("/{id}", name="backend_role_update")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("PUT")
     * @Template("CheeneBackendBundle:Role:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheeneUserBundle:Role')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backend_role_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Role entity.
     *
     * @Route("/{id}", name="backend_role_delete")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CheeneUserBundle:Role')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Role entity.');
            }

            $entity->steVisible(false);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_role_index'));
    }

    /**
     * Creates a form to delete a Role entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_role_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
