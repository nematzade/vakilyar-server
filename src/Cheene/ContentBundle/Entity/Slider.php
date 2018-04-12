<?php

namespace Cheene\ContentBundle\Entity;

use Cheene\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Slider
 *
 * @ORM\Table(name="Slider")
 * @ORM\Entity(repositoryClass="Cheene\ContentBundle\Entity\Repository\SliderRepository")
 * @Vich\Uploadable
 */
class Slider
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
     * @var string
     * @ORM\Column(name="title",type="string")
     */
    private $title;

    /**
     * @var integer
     * @ORM\Column(name="weight",type="integer")
     */
    private $weight;

    /**
     * @var string
     * @ORM\Column(name="header",type="string")
     */
    private $header;

    /**
     * @var string
     * @ORM\Column(name="text",type="string")
     */
    private $text;

    /**
     * @var string
     * @ORM\Column(name="link",type="string")
     */
    private $link = "http://www.example.com";

    /**
     * @var boolean
     * @ORM\Column(name="active",type="boolean")
     */
    private $active = true;

    /**
     * @ORM\Column(name="slider_image", type="string" , length=255 , nullable=true)
     */
    private $sliderImageName;


    /**
     * @Vich\UploadableField(mapping="user_profile_image", fileNameProperty="sliderImageName")
     */
    private $sliderImage;

    /**
     * unmapped
     *
     * @var string
     */
    private $sliderImageSource;


    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updated_at = NULL;

    /**
     * @ORM\ManyToOne(targetEntity="Cheene\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     **/
    private $created_by = NULL;

    /**
     * @ORM\ManyToOne(targetEntity="Cheene\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     **/
    private $updated_by = NULL;

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
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setSliderImage(File $image = null)
    {
        $this->sliderImage = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated_at = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getSliderImage()
    {
        return $this->sliderImage;
    }


    /**
     * Set sliderImageName
     *
     * @param string $sliderImageName
     *
     * @return Slider
     */
    public function setSliderImageName($sliderImageName)
    {
        $this->sliderImageName = $sliderImageName;

        return $this;
    }

    /**
     * Get sliderImageName
     *
     * @return string
     */
    public function getSliderImageName()
    {
        return $this->sliderImageName;
    }


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Slider
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
     * Set weight
     *
     * @param integer $weight
     *
     * @return Slider
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
     * Set header
     *
     * @param string $header
     *
     * @return Slider
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Slider
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Slider
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Slider
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Slider
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Slider
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set createdBy
     *
     * @param User $createdBy
     *
     * @return Slider
     */
    public function setCreatedBy(User $createdBy = null)
    {
        $this->created_by = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Set updatedBy
     *
     * @param User $updatedBy
     *
     * @return Slider
     */
    public function setUpdatedBy(User $updatedBy = null)
    {
        $this->updated_by = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return User
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }
}
