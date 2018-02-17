<?php
// src/Cheene/UserBundle/Entity/ActionGroup.php
namespace Cheene\UserBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cheene\UserBundle\Entity\ActionGroup
 *
 * @ORM\Table(name="ActionGroups")
 * @ORM\Entity(repositoryClass="Cheene\UserBundle\Entity\Repository\ActionGroupRepository")
 */
class ActionGroup
{
    /**
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     * @ORM\ManyToOne(targetEntity="ActionGroup")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\Column(name="code", type="string", length=32, nullable=false, unique=true)
     */
    private $code;

    /**
     * @ORM\Column(name="title", type="string", length=32, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    private $visible = true;

    /**
     * @ORM\ManyToMany(targetEntity="Cheene\UserBundle\Entity\Role", mappedBy="actionGroups")
     **/
    private $roles;

    /**
     * @ORM\ManyToMany(targetEntity="Cheene\UserBundle\Entity\Action", inversedBy="actionGroups")
     * @ORM\JoinTable(name="ActionGroups_Actions")
     **/
    private $actions;


    public function __construct() {
        $this->roles = new ArrayCollection();
        $this->actions = new ArrayCollection();
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
     * Set parent
     *
     * @param integer $parent
     * @return ActionGroup
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return integer 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return ActionGroup
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
     * @return ActionGroup
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
     * @return ActionGroup
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
     * Add roles
     *
     * @param \Cheene\UserBundle\Entity\Role $roles
     * @return ActionGroup
     */
    public function addRole(Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \Cheene\UserBundle\Entity\Role $roles
     */
    public function removeRole(Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * Add action
     *
     * @param \Cheene\UserBundle\Entity\Action $action
     * @return ActionGroup
     */
    public function addAction(Action $action)
    {
        $this->actions[] = $action;

        return $this;
    }

    /**
     * Remove action
     *
     * @param \Cheene\UserBundle\Entity\Action $action
     */
    public function removeAction(Action $action)
    {
        $this->actions->removeElement($action);
    }

    /**
     * Get actions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActions()
    {
        return $this->actions->toArray();
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
