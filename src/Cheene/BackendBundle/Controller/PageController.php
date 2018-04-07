<?php

namespace Cheene\BackendBundle\Controller;

use Cheene\UserBundle\Annotation\FrontendAccessible;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
}
