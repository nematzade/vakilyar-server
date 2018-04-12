<?php

namespace Cheene\BackendBundle\Controller;

use Cheene\ContentBundle\Entity\Page;
use Cheene\ContentBundle\Form\PageType;
use Cheene\UserBundle\Annotation\FrontendAccessible;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{

    /**
     * Page listing.
     *
     * @Route("/", name="backend_page_index")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $datatable = $this->get('page_datatables');
        $datatable->buildDatatable();

        return array(
            'datatable' => $datatable,
        );
    }

    /**
     * Get all Page entities.
     *
     * @Route("/results", name="backend_page_index_results", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('page_datatables');
        $datatable->buildDatatable();
        $datatableQuery = $this->get("sg_datatables.query")->getQueryFrom($datatable);
        return $datatableQuery->getResponse();
    }


    /**
     * Creates a new Page entity.
     *
     * @Route("/", name="backend_page_create")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("POST")
     * @Template("CheeneBackendBundle:Page:new.html.twig")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $entity = new Page();
        $form = $this->createNewPage($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setCreatedAt(new \DateTime());
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('backend_page_index'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Page entity.
     *
     * @param Page $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createNewPage(Page $entity)
    {
        $form = $this->createForm(new PageType(), $entity, array(
            'action' => $this->generateUrl('backend_page_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'label.submit', 'translation_domain' => 'labels', 'attr' => array(
            'class' => 'btn blue',
        )));

        return $form;
    }

    /**
     * Displays a form to create a new Page entity.
     *
     * @Route("/new", name="backend_page_new")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Page();
        $form = $this->createNewPage($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("/{id}/edit", name="backend_page_edit", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CheeneContentBundle:Page')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }
        $editForm = $this->createEditForm($entity);
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Page entity.
     *
     * @param Page $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Page $entity)
    {
        $form = $this->createForm(new PageType(), $entity, array(
            'action' => $this->generateUrl('backend_page_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'label.update', 'translation_domain' => 'labels', 'attr' => array(
            'class' => 'btn blue',
        )));

        return $form;
    }

    /**
     * Edits an existing Page entity.
     *
     * @Route("/{id}", name="backend_page_update")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("PUT")
     * @Template("CheeneBackendBundle:Page:edit.html.twig")
     *
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CheeneContentBundle:Page')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backend_page_index'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Page entity.
     *
     * @Route("/delete/{id}", name="backend_page_delete", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CheeneContentBundle:Page')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }
        $em->remove($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('backend_page_index'));
    }
}
