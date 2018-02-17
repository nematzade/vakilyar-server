<?php
// src/Cheene/Bundle/EventListener/OnKernelRequestHandler.php
namespace Cheene\CoreBundle\EventListener;

use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Class OnKernelRequestHandler
 * @package Cheene\CoreBundle\EventListener
 */
class OnKernelRequestHandler
{
    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * @var Router
     */
    private $router;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->router = $container->get('router');
    }

    public function onKernelController(FilterControllerEvent $event)
    {
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
    }
}
