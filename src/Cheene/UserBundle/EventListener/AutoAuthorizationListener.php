<?php

namespace Cheene\UserBundle\EventListener;

use Cheene\UserBundle\Annotation\FrontendAccessible;
use Cheene\UserBundle\Entity\Constants\UserConstants;
use Cheene\UserBundle\Entity\User;
use Cheene\UserBundle\Entity\Role;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Tests\Controller;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class AutoAuthorizationListener
 * @package Cheene\UserBundle\EventListener
 * Auto authorizes users before the controller code called.
 */
class AutoAuthorizationListener {
    private $authorizationChecker;
    private $tokenStorage;
    private $annotationReader;
    private $controller;
    private $controller_name;
    private $action_name;
    private $annotationClass = 'Cheene\\UserBundle\\Annotation\\FrontendAccessible';

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, TokenStorage $tokenStorage,
                                AnnotationReader $annotationReader)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param FilterControllerEvent $event
     * Event listener for auto authorization
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $this->controller = $event->getController();
        /**
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (! is_array($this->controller)) {
            throw new Exception('$controller is not an array');
        }
        // TODO: check is controller class var
        $isControllerClass = $this->getControllerName($event);
        if (! $isControllerClass) {
            return;
        }
        $token = $this->tokenStorage->getToken();
        /**
         * Handle guest users
         * It may not be reached since the firewalls block anonymous users.
         * Though for more reliability we check the access.
         */
        if (is_null($token) || ($token instanceof AnonymousToken) ) {

            if (! $this->checkGuestAccess($event)) {
               throw new AccessDeniedException();
            }
            return; // skipping extra process
        }
        /**
         * @var User $user
         * Handle registered users (backend and frontend)
         */
        $user = $token->getUser();
        if (! $user) {
            throw new AccessDeniedException();
        } else if ($user->getType() == UserConstants::TYPE_BACKEND) {
            if ($user->getDeleted() == true) {
                throw new AccessDeniedException();
            }
            // Super admin has access to everything
            if ($user->hasRole(Role::ROLE_SUPER_ADMIN)) {
                return;
            }
            if ($this->checkCustomerAccess($event)) {
                return;
            }
            if (! $this->checkBackendAccess($event)) {
                throw new AccessDeniedException();
            }
        } else if ($user->getType() == UserConstants::TYPE_FRONTEND) {
            if (! $this->checkCustomerAccess($event)) {
                throw new AccessDeniedException();
            }
        } else {
            throw new Exception('Unknown type of User is given');
        }
        // return to controller
        return;
    }


    /**
     * Checks if guests have access to the requested action or not
     * This permission is given by Annotations
     * @param $event FilterControllerEvent Action request event
     * @return bool whether guests have access to the requested action or not
     */
    public function checkGuestAccess($event) {
        $reflectionObject = new \ReflectionObject($this->controller[0]);
        $actionName = $this->action_name.'Action';
        $reflectionMethod = $reflectionObject->getMethod($actionName);
        // fetch the @StandardObject annotation from the annotation reader
        /** @var FrontendAccessible $annotation */
        $annotation = $this->annotationReader->getMethodAnnotation($reflectionMethod, $this->annotationClass);
        if (null !== $annotation) {
            if ($annotation->isGuestAccessible()) {
                return true;
            }
        } else {
            return false;
        }
        return false;
    }

    /**
     * Checks if a frontend User have access to the requested action or not
     * This permission is given by Annotations
     * @param $event FilterControllerEvent Action request event
     * @return bool whether a frontend User have access to the requested action or not
     */
    public function checkCustomerAccess($event)
    {

        $reflectionObject = new \ReflectionObject($this->controller[0]);
        $actionName = $this->action_name.'Action';
        $reflectionMethod = $reflectionObject->getMethod($actionName);
        // fetch the @StandardObject annotation from the annotation reader
        /** @var FrontendAccessible $annotation */
        $annotation = $this->annotationReader->getMethodAnnotation($reflectionMethod, $this->annotationClass);
        if (null !== $annotation) {
            if ($annotation->isCustomerAccessible()) {
                return true;
            }
        } else {
            return false;
        }
        return false;
    }

    /**
     * Checks if a backend have access to the requested action or not
     * This permission is given by the RBAC system
     * @param $event FilterControllerEvent Action request event
     * @return bool whether a backend User have access to the requested action or not
     */
    public function checkBackendAccess($event)
    {
        $action = 'ACTION_'.strtoupper($this->controller_name).'_'.strtoupper($this->action_name);
        return $this->authorizationChecker->isGranted($action);
    }

    /**
     * @param FilterControllerEvent $event
     * get Controller and Action Name
     * @return bool
     */
    public function getControllerName($event)
    {
        $controller_class = $event->getRequest()->attributes->get('_controller');
        preg_match('/(.*)\\\(.*)Bundle\\\Controller\\\(.*)Controller::(.*)Action/', $controller_class, $matches);
        // static pages or not controller/action based URLs
        if (empty($matches)) {
            return false;
        }
        $this->controller_name = $matches[3];
        $this->action_name = $matches[4];
        return true;
    }
}
