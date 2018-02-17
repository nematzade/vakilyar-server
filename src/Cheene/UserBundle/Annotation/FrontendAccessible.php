<?php
namespace Cheene\UserBundle\Annotation;

use Symfony\Component\Form\Guess\Guess;

/**
 * Annotation class for @FrontendAccessible()
 *
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 *
 */
final class FrontendAccessible {
    public $guestAccessible= false;
    public $customerAccessible = false;
    public $adminAccessible = false;

    /**
     * @return boolean
     */
    public function isGuestAccessible()
    {
        return $this->guestAccessible;
    }

    /**
     * @return boolean
     */
    public function isCustomerAccessible()
    {
        return $this->customerAccessible || $this->isGuestAccessible();
    }

    /**
     * @return boolean
     */
    public function isAdminAccessible()
    {
        return $this->adminAccessible || $this->isCustomerAccessible();
    }
}