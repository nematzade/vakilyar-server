<?php

namespace Cheene\BackendBundle\Controller;

use Cheene\UserBundle\Annotation\FrontendAccessible;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
}
