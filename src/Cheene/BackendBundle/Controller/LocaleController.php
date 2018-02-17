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

class LocaleController extends Controller
{
    /**
     * Change language of the software
     * @Route("/switch" , name="backend_locale_change")
     * @Method("GET")
     * @FrontendAccessible(guestAccessible=true)
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeLocaleAction(Request $request)
    {
        $locale = $request->getLocale();
        $request->getSession()->set('_locale', $locale);

        $referer = $request->headers->get('referer');
        if (empty($referer)) {
            throw $this->createNotFoundException();
        }

        return $this->redirect($referer);
    }
}
