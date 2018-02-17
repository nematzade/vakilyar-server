<?php

namespace Cheene\UserBundle\Entity\Lifecycle;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Cheene\CoreBundle\Entity\Lifecycle\BaseListener;
use Cheene\UserBundle\Entity\User;
use Doctrine\ORM\Events;
use libphonenumber\PhoneNumberFormat;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
/**
 * Class UserListener
 * @package Cheene\UserBundle\Entity\Lifecycle
 */
class UserListener extends BaseListener
{
    /**
     * Set extra events
     *
     * @return array
     */
    protected function getChildSubscribedEvents() {
        return array(Events::postLoad);
    }

    /**
     * This must be called for calling the prepareImgSrc() function
     *
     * @param User $object
     */
    public function postLoad($object) {
        $phoneNumberUtil = $this->container->get('libphonenumber.phone_number_util');
        $cellphone = $object->getCellphone();
        $plainCellphone = '';
        if ($cellphone) {
            $plainCellphone = $phoneNumberUtil->format($cellphone, PhoneNumberFormat::NATIONAL);
        }
        $object->setPlainCellphone($plainCellphone);;
    }

    /**
     * This must be called on prePersist and preUpdate if the event is about a
     * User.
     *
     * @param User $object
     * @internal param UserInterface $User
     */
    protected function updateFields($object)
    {
        parent::updateFields($object);
        if ($object->getLastSeen() == null || $object->getLastname() == '') {
            $defaultLastSeen = new \DateTime('1997-01-01 00:00:00');
            $object->setLastSeen($defaultLastSeen);
        }
        $this->updatePassword($object);
    }

    /**
     * @param User $object
     */
    public function updatePassword($object)
    {
        if (0 !== strlen($password = $object->getPlainPassword())) {
            $encoder = $this->getEncoder($object);
            $object->setPassword($encoder->encodePassword($object, $password));
            $object->eraseCredentials();
        }
    }

    /**
     * @param UserInterface $user
     * @return \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface
     */
    protected function getEncoder(UserInterface $user)
    {
        return $this->container->get('security.password_encoder');
    }
};