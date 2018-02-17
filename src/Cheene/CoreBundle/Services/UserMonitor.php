<?php
/**
 * Created by PhpStorm.
 * User: reza
 * Date: 8/23/16
 * Time: 6:51 PM
 */
namespace Cheene\CoreBundle\Services;

use Cheene\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpKernel\HttpKernel;

class UserMonitor
{
    /** @var  TokenStorage $tokenStorage */
    protected $tokenStorage;
    /** @var  ContainerInterface $container */
    protected $container;

    /**
     * UserMonitor constructor.
     * @param TokenStorage $securityContext
     * @param ContainerInterface $containerInterface
     */
    public function __construct(TokenStorage $securityContext , ContainerInterface $containerInterface)
    {
        $this->tokenStorage = $securityContext;
        $this->container = $containerInterface;
    }

    /**
     * Update the user "lastActivity" on each request
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $em = $this->container->get('doctrine')->getManager();
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }
        // Check token authentication availability
        if ($this->tokenStorage->getToken()) {
            $user = $this->tokenStorage->getToken()->getUser();

            if (($user instanceof User) && !($user->isActiveNow())) {
                $user->setLastSeen(new \DateTime());
                $em->persist($user);
                $em->flush();
            }
        }
    }
}