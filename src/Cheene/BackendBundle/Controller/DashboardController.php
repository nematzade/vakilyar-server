<?php

namespace Cheene\BackendBundle\Controller;

use Cheene\UserBundle\Annotation\FrontendAccessible;
use Cheene\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DashboardController extends Controller
{
    /**
     * @Route("/" , name="backend_dashboard_index", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        /** @var User $user */
        $user = $this->getUser();
        return array(
            'data' => $user->getRoles()
        );
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id}/edit", name="post_edit", options={"expose"=true})
     * @FrontendAccessible(adminAccessible=true)
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        // ...
        dump('dump');
        die();
    }

}
