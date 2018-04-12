<?php

namespace Cheene\BackendBundle\Controller;

use Cheene\ContentBundle\Entity\Menu;
use Cheene\ContentBundle\Form\MenuType;
use Cheene\UserBundle\Annotation\FrontendAccessible;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class MenuController extends Controller
{

    /**
     * Menu listing.
     *
     * @Route("/", name="backend_menu_index")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $datatable = $this->get('menu_datatables');
        $datatable->buildDatatable();

        return array(
            'datatable' => $datatable,
        );
    }

    /**
     * Get all Menu entities.
     *
     * @Route("/results", name="backend_menu_index_results", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('menu_datatables');
        $datatable->buildDatatable();
        $datatableQuery = $this->get("sg_datatables.query")->getQueryFrom($datatable);
        return $datatableQuery->getResponse();
    }


    /**
     * Creates a new Menu entity.
     *
     * @Route("/", name="backend_menu_create")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("POST")
     * @Template("CheeneBackendBundle:Menu:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Menu();
        $form = $this->createNewMenu($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_menu_index'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Menu entity.
     *
     * @param Menu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createNewMenu(Menu $entity)
    {
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('backend_menu_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'label.submit', 'translation_domain' => 'labels', 'attr' => array(
            'class' => 'btn blue',
        )));

        return $form;
    }

    /**
     * Displays a form to create a new Menu entity.
     *
     * @Route("/new", name="backend_menu_new")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Menu();
        $form = $this->createNewMenu($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Menu entity.
     *
     * @Route("/{id}/edit", name="backend_menu_edit", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CheeneContentBundle:Menu')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }
        $editForm = $this->createEditForm($entity);
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Menu entity.
     *
     * @param Menu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Menu $entity)
    {
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('backend_menu_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'label.update', 'translation_domain' => 'labels', 'attr' => array(
            'class' => 'btn blue',
        )));

        return $form;
    }

    /**
     * Edits an existing Menu entity.
     *
     * @Route("/{id}", name="backend_menu_update")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("PUT")
     * @Template("CheeneBackendBundle:Menu:edit.html.twig")
     *
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CheeneContentBundle:Menu')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backend_menu_index'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Menu entity.
     *
     * @Route("/delete/{id}", name="backend_menu_delete", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CheeneContentBundle:Menu')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }
        $em->remove($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('backend_menu_index'));
    }
}
