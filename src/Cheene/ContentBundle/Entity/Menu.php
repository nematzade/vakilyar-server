<?php

namespace Cheene\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="Menu")
 * @ORM\Entity(repositoryClass="Cheene\ContentBundle\Entity\Repository\MenuRepository")
 */
class Menu
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cheene\ContentBundle\Entity\Menu", inversedBy="child")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id",nullable=true)
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Cheene\ContentBundle\Entity\Menu", mappedBy="parent")
     */
    protected $child;


    /**
     * @var integer
     * @ORM\Column(name="weight",type="integer")
     */
    private $weight = 100;

    /**
     * @var int
     * @ORM\Column(name="menu_order",type="integer")
     */
    private $menuOrder = 1;

    /**
     * @var
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var
     * @ORM\Column(name="link",type="string")
     */
    private $link = "http://www.yourlink.com/menu";

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->child = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return Menu
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Menu
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
     * Set link
     *
     * @param string $link
     *
     * @return Menu
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set parent
     *
     * @param \Cheene\ContentBundle\Entity\Menu $parent
     *
     * @return Menu
     */
    public function setParent(\Cheene\ContentBundle\Entity\Menu $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Cheene\ContentBundle\Entity\Menu
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \Cheene\ContentBundle\Entity\Menu $child
     *
     * @return Menu
     */
    public function addChild(\Cheene\ContentBundle\Entity\Menu $child)
    {
        $this->child[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Cheene\ContentBundle\Entity\Menu $child
     */
    public function removeChild(\Cheene\ContentBundle\Entity\Menu $child)
    {
        $this->child->removeElement($child);
    }

    /**
     * Get child
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * Set menuOrder
     *
     * @param integer $menuOrder
     *
     * @return Menu
     */
    public function setMenuOrder($menuOrder)
    {
        $this->menuOrder = $menuOrder;

        return $this;
    }

    /**
     * Get menuOrder
     *
     * @return integer
     */
    public function getMenuOrder()
    {
        return $this->menuOrder;
    }
}
