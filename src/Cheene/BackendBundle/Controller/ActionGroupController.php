<?php

namespace Cheene\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cheene\UserBundle\Entity\ActionGroup;
use Cheene\UserBundle\Form\Type\ActionGroupType;
use Cheene\UserBundle\Annotation\FrontendAccessible;

/**
 * ActionGroup controller.
 *
 * @Route("/")
 */
class ActionGroupController extends Controller
{
    /**
     * ActionGroup listing.
     *
     * @Route("/", name="backend_action_group_index")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $actionGroupDatatable = $this->get("actiongroup_datatables");
        $actionGroupDatatable->buildDatatable();

        return array(
            "datatable" => $actionGroupDatatable,
        );
    }

    /**
     * Get all User entities.
     *
     * @Route("/results", name="backend_action_group_results")
     * @FrontendAccessible(adminAccessible=true)
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexResultsAction()
    {
        $actionGroupDatatable = $this->get("actiongroup_datatables");
        $actionGroupDatatable->buildDatatable();

        $datatable = $this->get("sg_datatables.query")->getQueryFrom($actionGroupDatatable);
        return $datatable->getResponse();
    }

    /**
     * Creates a new ActionGroup entity.
     *
     * @Route("/", name="backend_action_group_create")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("POST")
     * @Template("CheeneBackendBundle:ActionGroup:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ActionGroup();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_action_group_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ActionGroup entity.
     *
     * @param ActionGroup $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ActionGroup $entity)
    {
        $form = $this->createForm(new ActionGroupType(), $entity, array(
            'action' => $this->generateUrl('backend_action_group_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'label.submit', 'translation_domain' => 'labels', 'attr' => array(
            'class' => 'btn blue',
        )));

        return $form;
    }

    /**
     * Displays a form to create a new ActionGroup entity.
     *
     * @Route("/new", name="backend_action_group_new")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ActionGroup();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ActionGroup entity.
     *
     * @Route("/{id}", name="backend_action_group_show", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheeneUserBundle:ActionGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActionGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ActionGroup entity.
     *
     * @Route("/{id}/edit", name="backend_action_group_edit", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheeneUserBundle:ActionGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActionGroup entity.');
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
    * Creates a form to edit a ActionGroup entity.
    *
    * @param ActionGroup $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ActionGroup $entity)
    {
        $form = $this->createForm(new ActionGroupType(), $entity, array(
            'action' => $this->generateUrl('backend_action_group_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'label.update', 'translation_domain' => 'labels', 'attr' => array(
            'class' => 'btn blue',
        )));

        return $form;
    }
    /**
     * Edits an existing ActionGroup entity.
     *
     * @Route("/{id}", name="backend_action_group_update")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("PUT")
     * @Template("CheeneBackendBundle:ActionGroup:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CheeneUserBundle:ActionGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActionGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backend_action_group_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ActionGroup entity.
     *
     * @Route("/{id}", name="backend_action_group_delete")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CheeneUserBundle:ActionGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ActionGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_action_group_index'));
    }

    /**
     * Creates a form to delete a ActionGroup entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_action_group_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
