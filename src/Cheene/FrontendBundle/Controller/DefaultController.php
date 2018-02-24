<?php

namespace Cheene\FrontendBundle\Controller;

use Cheene\UserBundle\Annotation\FrontendAccessible;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="frontend_index")
     * @FrontendAccessible(guestAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}
