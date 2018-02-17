<?php

namespace Cheene\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cheene\UserBundle\Entity\Action;
use Cheene\UserBundle\Form\Type\ActionType;
use Cheene\UserBundle\Annotation\FrontendAccessible;

/**
 * Action controller.
 *
 * @Route("/")
 */
class ActionController extends Controller
{
    /**
     * Lists all Action entities.
     *
     * @Route("/", name="backend_action_index")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CheeneUserBundle:Action')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Action entity.
     *
     * @Route("/", name="backend_action_create")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("POST")
     * @Template("CheeneBackendBundle:Action:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Action();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('action_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Action entity.
     *
     * @param Action $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Action $entity)
    {
        $form = $this->createForm(new ActionType(), $entity, array(
            'action' => $this->generateUrl('backend_action_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Action entity.
     *
     * @Route("/new", name="backend_action_new")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Action();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Action entity.
     *
     * @Route("/{id}", name="backend_action_show")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheeneUserBundle:Action')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Action entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Action entity.
     *
     * @Route("/{id}/edit", name="backend_action_edit")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheeneUserBundle:Action')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Action entity.');
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
    * Creates a form to edit a Action entity.
    *
    * @param Action $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Action $entity)
    {
        $form = $this->createForm(new ActionType(), $entity, array(
            'action' => $this->generateUrl('action_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Action entity.
     *
     * @Route("/{id}", name="action_update")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("PUT")
     * @Template("BodoFoodBackendBundle:Action:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheeneUserBundle:Action')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Action entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backend_action_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Action entity.
     *
     * @Route("/{id}", name="backend_action_delete")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CheeneUserBundle:Action')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Action entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_action_index'));
    }

    /**
     * Creates a form to delete a Action entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_action_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
