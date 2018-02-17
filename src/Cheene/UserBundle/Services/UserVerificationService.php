<?php

namespace Cheene\UserBundle\Services;

use Cheene\UserBundle\Entity\Constants\UserConstants;
use Cheene\UserBundle\Entity\User;
use Cheene\UserBundle\Entity\UserForgotPassword;
use Cheene\UserBundle\Entity\UserVerificationToken;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserVerificationService
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var EntityManager
     */
    private $em;


    /**
     * UserVerificationService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->logger = $container->get('logger');
        $this->em = $container->get('doctrine.orm.default_entity_manager');
    }

    /**
     * @param $user
     * @return mixed
     */
    public function hasAlreadyForgetPasswordToken($user)
    {
        $userPasswordToken = $this->em->getRepository('CheeneUserBundle:UserForgotPassword');
        return $userPasswordToken->hasAlreadyForgetPasswordToken($user);
    }

    /**
     * @param User $user
     * @return UserForgotPassword
     */
    public function generateForgetPasswordTokenViaSMS(User $user)
    {
        $token = $this->generateSMSToken();

        $expiresAt = new \DateTime(UserConstants::FORGET_PASSWORD_LIFECYCLE);

        $forget = new UserForgotPassword();
        $forget->setUser($user);
        $forget->setToken($token);
        $forget->setExpiresAt($expiresAt);

        $this->em->persist($forget);
        $this->em->flush();

        return $forget;
    }

    /**
     * @param User $user
     * @return UserVerificationToken
     */
    public function generateNewToken(User $user)
    {
        $emailToken = $this->generateEmailToken();
        $smsToken = $this->generateSMSToken();

        $expiresAt = new \DateTime('+5 min');

        $verification = new UserVerificationToken();
        $verification->setUser($user);
        $verification->setEmailToken($emailToken);
        $verification->setSmsToken($smsToken);
        $verification->setExpiresAt($expiresAt);

        $this->em->persist($verification);
        $this->em->flush();

        return $verification;
    }

    /**
     * @param User $user
     * @param $code
     * @return int
     */
    public function verifyForgetToken(User $user, $code)
    {
        $responseCode = 0; // Code not found

        $userPasswordTokenRepository = $this->em->getRepository('CheeneUserBundle:UserForgotPassword');
        /** @var UserForgotPassword $token */
        $token = $userPasswordTokenRepository->getActiveToken($user);
        if ($token) {
            if ($token->getToken() == $code) {
                $token->setUsed(true);
                $responseCode = 1; // Found, Verified
            } else if ($token->getGenerateTries() > 5) {
                $responseCode = 3; // Exceeded tries
                $token->setExpired(true);
            } else {
                $token->increaseGenerateTries();
                $responseCode = 2; // Wrong
            }
        }

        $this->em->flush();

        return $responseCode;
    }

    private function generateEmailToken()
    {
        return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    private function generateSMSToken()
    {
        $min = 10000;
        $max = 99999;

        return mt_rand($min, $max);
    }

    public function verifyUserPhone($number)
    {
        $number=str_replace("۱","1",$number);
        $number=str_replace("۲","2",$number);
        $number=str_replace("۳","3",$number);
        $number=str_replace("۴","4",$number);
        $number=str_replace("۵","5",$number);
        $number=str_replace("۶","6",$number);
        $number=str_replace("۷","7",$number);
        $number=str_replace("۸","8",$number);
        $number=str_replace("۹","9",$number);
        $number=str_replace("۰","0",$number);
        $number=str_replace(" ","",$number);

        return $number;
    }
}
