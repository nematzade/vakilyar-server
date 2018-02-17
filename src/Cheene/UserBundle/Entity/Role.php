<?php
// src/Cheene/UserBundle/Entity/Role.php
namespace Cheene\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Cheene\UserBundle\Entity\Role
 *
 * @ORM\Table(name="Roles", indexes={@ORM\Index(name="role_index", columns={"role"}) })
 * @ORM\Entity(repositoryClass="Cheene\UserBundle\Entity\Repository\RoleRepository")
 */
class Role implements RoleInterface
{
    const ROLE_SUPER_ADMIN = "ROLE_SUPER_ADMIN";
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_CUSTOMER = "ROLE_USER";

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=80, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(name="role", type="string", length=80, unique=true)
     */
    private $role;

    /**
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    private $visible = true;

    /**
     * @ORM\ManyToMany(targetEntity="Cheene\UserBundle\Entity\User", mappedBy="roles")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="Cheene\UserBundle\Entity\ActionGroup", inversedBy="roles")
     * @ORM\JoinTable(name="ActionGroups_Roles")
     */
    private $actionGroups;


    public function __construct() {
        $this->users = new ArrayCollection();
        $this->actionGroups = new ArrayCollection();
    }

    /**
     * Returns the role.
     *
     * This method returns a string representation whenever possible.
     *
     * When the role cannot be represented with sufficient precision by a
     * string, it should return null.
     *
     * @return string|null A string representation of the role, or null
     */
    public function getRole()
    {
        return $this->role;
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
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return Role
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
     * Add users
     *
     * @param \Cheene\UserBundle\Entity\User $users
     * @return Role
     */
    public function addUser(User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Cheene\UserBundle\Entity\User $users
     */
    public function removeUser(User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add actionGroups
     *
     * @param \Cheene\UserBundle\Entity\ActionGroup $actionGroups
     * @return Role
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
        return $this->actionGroups;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Role
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
}
