<?php

namespace Cheene\BackendBundle\Controller;

use Cheene\ContentBundle\Entity\Slider;
use Cheene\ContentBundle\Form\SliderType;
use Cheene\UserBundle\Annotation\FrontendAccessible;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SliderController extends Controller
{

    /**
     * Slider listing.
     *
     * @Route("/", name="backend_slider_index")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $datatable = $this->get('slider_datatables');
        $datatable->buildDatatable();

        return array(
            'datatable' => $datatable,
        );
    }

    /**
     * Get all Slider entities.
     *
     * @Route("/results", name="backend_slider_index_results", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('slider_datatables');
        $datatable->buildDatatable();
        $datatableQuery = $this->get("sg_datatables.query")->getQueryFrom($datatable);
        return $datatableQuery->getResponse();
    }

    /**
     * Creates a new Slider entity.
     *
     * @Route("/", name="backend_slider_create")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("POST")
     * @Template("CheeneBackendBundle:Slider:new.html.twig")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $entity = new Slider();
        $form = $this->createNewSlider($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setCreatedAt(new \DateTime());
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('backend_slider_index'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Slider entity.
     *
     * @param Slider $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createNewSlider(Slider $entity)
    {
        $form = $this->createForm(new SliderType(), $entity, array(
            'action' => $this->generateUrl('backend_slider_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'label.submit', 'translation_domain' => 'labels', 'attr' => array(
            'class' => 'btn blue',
        )));

        return $form;
    }

    /**
     * Displays a form to create a new Slider entity.
     *
     * @Route("/new", name="backend_slider_new")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Slider();
        $form = $this->createNewSlider($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Slider entity.
     *
     * @Route("/{id}/edit", name="backend_slider_edit", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CheeneContentBundle:Slider')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }
        $editForm = $this->createEditForm($entity);
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Slider entity.
     *
     * @param Slider $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Slider $entity)
    {
        $form = $this->createForm(new SliderType(), $entity, array(
            'action' => $this->generateUrl('backend_slider_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'label.update', 'translation_domain' => 'labels', 'attr' => array(
            'class' => 'btn blue',
        )));

        return $form;
    }

    /**
     * Edits an existing Slider entity.
     *
     * @Route("/{id}", name="backend_slider_update")
     * @FrontendAccessible(adminAccessible=true)
     * @Method("PUT")
     * @Template("CheeneBackendBundle:Slider:edit.html.twig")
     *
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CheeneContentBundle:Slider')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('backend_slider_index'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Slider entity.
     *
     * @Route("/delete/{id}", name="backend_slider_delete", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CheeneContentBundle:Slider')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }
        $em->remove($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('backend_slider_index'));
    }
}
