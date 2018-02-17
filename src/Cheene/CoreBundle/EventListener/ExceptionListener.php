<?php
namespace Cheene\CoreBundle\EventListener;


use Monolog\Logger;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\ProviderNotFoundException;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dump\Container;


class ExceptionListener
{
    /** @var ContainerInterface */
    private $container;

    /** @var \Symfony\Bridge\Monolog\Logger */
    private $logger;

    /** @var null error code */
    private $error_code = null;

    /** @var null error raw message */
    private $error_rawMessage= null;

    /** @var null error message */
    private $error_message = null;

    /** @var null error level */
    private $error_level = null;

    public function __construct($container)
    {
        $this->container = $container;
        $this->logger = $this->container->get('logger');
    }

    // lets show errors in our own way!
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
          return ; // TODO.SYSTEM: UNCOMMENT THIS FUCKING LINE TO SEE SYSTEM ERRORS IN SYMFONY STYLE!
        $exception = $event->getException();
        if ($exception instanceof NotFoundHttpException) {
            $this->error_code = $exception->getCode();
            $this->error_rawMessage = $exception->getMessage();
            $this->error_message = $exception->getMessage();
            $this->error_level = 'ERROR';
            $this->logger->log(
                $this->error_level,$this->error_message
            );
        }

        $message = sprintf(
            $this->error_message,
            $exception->getMessage(),
            $exception->getCode()
        );

        $response = new Response();
        $response->setContent('an error occurred');

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}