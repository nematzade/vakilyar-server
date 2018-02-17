<?php
// src/Cheene/UserBundle/Entity/UserVerificationToken.php
namespace Cheene\UserBundle\Entity;

use Cheene\CoreBundle\Entity\TimestampedEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Cheene\UserBundle\Entity\UserVerificationToken
 *
 * @ORM\Table(name="UserVerificationTokens",uniqueConstraints={
 *          @ORM\UniqueConstraint(name="cellphoneUser",columns={"cellphone","user_id"})
 *     })
 * @ORM\Entity(repositoryClass="Cheene\UserBundle\Entity\Repository\UserVerificationTokenRepository")
 */
class UserVerificationToken implements TimestampedEntity
{
    /**
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cheene\UserBundle\Entity\User", inversedBy="verificationToken")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(name="sms_token", type="string", length=32, nullable=false)
     */
    private $smsToken;

    /**
     * @ORM\Column(name="email_token", type="string", length=32, nullable=true)
     */
    private $emailToken;

    /**
     * @ORM\Column(name="used", type="boolean", nullable=false, nullable=true)
     */
    private $used = false;

    /**
     * @ORM\Column(name="expired", type="boolean", nullable=true)
     */
    private $expired = false;

    /**
     * @ORM\Column(name="used_at", type="datetime", nullable=true)
     */
    private $usedAt = NULL;

    /**
     * @ORM\Column(name="expires_at", type="datetime", nullable=true)
     */
    private $expiresAt = NULL;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt = NULL;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt = NULL;

    /**
     * @ORM\Column(name="cellphone", type="phone_number" , nullable=true)
     */
    private $cellphone;


    /**
     * @ORM\Column(name="plain_cellphone", type="string", length=32, nullable=true)
     */
    private $plainCellphone;


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UserVerificationToken
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return UserVerificationToken
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set used
     *
     * @param boolean $used
     * @return UserVerificationToken
     */
    public function setUsed($used)
    {
        $this->used = $used;

        return $this;
    }

    /**
     * Get used
     *
     * @return boolean
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * Set user
     *
     * @param \Cheene\UserBundle\Entity\User $user
     * @return UserVerificationToken
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Cheene\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getSmsToken()
    {
        return $this->smsToken;
    }

    /**
     * @param mixed $smsToken
     */
    public function setSmsToken($smsToken)
    {
        $this->smsToken = $smsToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmailToken()
    {
        return $this->emailToken;
    }

    /**
     * @param mixed $emailToken
     */
    public function setEmailToken($emailToken)
    {
        $this->emailToken = $emailToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsedAt()
    {
        return $this->usedAt;
    }

    /**
     * @param mixed $usedAt
     */
    public function setUsedAt($usedAt)
    {
        $this->usedAt = $usedAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * @param mixed $expired
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param mixed $expiresAt
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Set cellphone
     *
     * @param phone_number $cellphone
     * @return UserVerificationToken
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;

        return $this;
    }

    /**
     * Get cellphone
     *
     * @return phone_number 
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * Set plainCellphone
     *
     * @param string $plainCellphone
     * @return UserVerificationToken
     */
    public function setPlainCellphone($plainCellphone)
    {
        $this->plainCellphone = $plainCellphone;

        return $this;
    }

    /**
     * Get plainCellphone
     *
     * @return string 
     */
    public function getPlainCellphone()
    {
        return $this->plainCellphone;
    }
}
