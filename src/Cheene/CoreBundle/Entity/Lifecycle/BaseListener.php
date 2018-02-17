<?php

namespace Cheene\CoreBundle\Entity\Lifecycle;

use Doctrine\Common\EventSubscriber;
use Hashids\Hashids;
use Cheene\CoreBundle\Entity\TimestampedEntity;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Cheene\UserBundle\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
/**
 * Class BaseListener
 * @package Cheene\CoreBundle\Entity\Lifecycle
 */
abstract class BaseListener implements EventSubscriber
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Returns an array of events child class subscriber wants to listen to.
     * @return array
     */
    protected function getChildSubscribedEvents() {
        return array();
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        $defaultEvents = array(
            Events::prePersist,
            Events::preUpdate,
            Events::postPersist,
            Events::postUpdate,
        );
        $mergedEvents = array_merge($defaultEvents, $this->getChildSubscribedEvents());

        return array_unique($mergedEvents);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist($object, LifecycleEventArgs $args)
    {
        $this->updateFields($object);
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate($object, PreUpdateEventArgs $args)
    {
        $this->updateFields($object);
        // We are doing a update, so we must force Doctrine to update the
        // changeset in case we changed something above
        $em   = $args->getEntityManager();
        $uow  = $em->getUnitOfWork();
        $meta = $em->getClassMetadata(get_class($object));
        $uow->recomputeSingleEntityChangeSet($meta, $object);
    }

//    public function postPersist($object, LifecycleEventArgs $args){
//        $this->afterUpdateFields($object);
//    }
//
//    public function postUpdate($object , LifecycleEventArgs $args){
//        $this->afterUpdateFields($object);
//    }

    /**
     * This must be called on prePersist and preUpdate if the event is about a
     * User.
     *
     * @param Object $object
     */
    protected function updateFields($object)
    {
        if ($object instanceof TimestampedEntity)
        {
            $now = new \DateTime();
            if (! $object->getCreatedAt())
                $object->setCreatedAt($now);
            $object->setUpdatedAt($now);
        }

    }

    /**
     * Prepares suitable code for object
     *
     * @param Hashids $object
     */
    public function prepareCodeForObject(&$object) {
        $hashIds = $this->container->get('hashids');
        $code = $hashIds->encode($object->getId());
        $object->setCode(str_replace('/','$$',$code));
    }

    public function prepareJDateForObject(&$object)
    {
        $jDate = $this->container->get('symfony_persia.jdate');
        $object->setJDate($jDate->date("Y/m/d H:i", $object->getCreatedAt()->getTimestamp()));
    }
}
