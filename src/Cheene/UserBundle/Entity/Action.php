<?php
// src/Cheene/UserBundle/Entity/Action.php
namespace Cheene\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cheene\UserBundle\Entity\Action
 *
 * @ORM\Table(name="Actions")
 * @ORM\Entity(repositoryClass="Cheene\UserBundle\Entity\Repository\ActionRepository")
 */
class Action
{
    /**
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="code", type="string", length=128, nullable=false, unique=true)
     */
    private $code;

    /**
     * @ORM\Column(name="title", type="string", length=128, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(name="visible", type="integer", length=4, nullable=false)
     */
    private $visible = true;

    /**
     * @ORM\ManyToMany(targetEntity="ActionGroup", mappedBy="actions")
     **/
    private $actionGroups;


    public function __construct() {
        $this->actionGroups = new ArrayCollection();
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
     * Set code
     *
     * @param string $code
     * @return Action
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Action
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return Action
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Add actionGroups
     *
     * @param \Cheene\UserBundle\Entity\ActionGroup $actionGroups
     * @return Action
     */
    public function addActionGroup(ActionGroup $actionGroups)
    {
        $this->actionGroups[] = $actionGroups;

        return $this;
    }

    /**
     * Remove actionGroups
     *
     * @param \Cheene\UserBundle\Entity\ActionGroup $actionGroups
     */
    public function removeActionGroup(ActionGroup $actionGroups)
    {
        $this->actionGroups->removeElement($actionGroups);
    }

    /**
     * Get actionGroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActionGroups()
    {
        return $this->actionGroups->toArray();
    }

    public function __toString()
    {
        return $this->getCode();
    }
}
