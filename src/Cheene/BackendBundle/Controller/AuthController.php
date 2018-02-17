<?php

namespace Cheene\BackendBundle\Controller;

use Cheene\UserBundle\Annotation\FrontendAccessible;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auth controller.
 *
 * @Route("/")
 */
class AuthController extends Controller
{
    /**
     * @Route(path="/login", name="backend_auth_login")
     * @FrontendAccessible(guestAccessible=true)
     * @Template
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error' => $error,
        );
    }

    /**
     * @Route(path="/login_check", name="backend_auth_login_check")
     * @FrontendAccessible(guestAccessible=true)
     */
    public function loginCheckAction() {
        return new Response('');
    }

    /**
     * @Route(path="/logout", name="backend_auth_logout")
     * @FrontendAccessible(customerAccessible=true)
     */
    public function logoutAction() {
        return new Response('');
    }
}
