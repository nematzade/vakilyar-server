<?php

namespace Cheene\ContentBundle\Entity;

use Cheene\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Page
 *
 * @ORM\Table(name="Page")
 * @ORM\Entity(repositoryClass="Cheene\ContentBundle\Entity\Repository\PageRepository")
 * @Vich\Uploadable
 */
class Page
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
     * @var
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var \DateTime
     * @ORM\Column(name="release_date",type="datetime")
     */
    private $releaseDate;

    /**
     * @var string unmapped
     */
    private $jalaliReleaseDate;

    /**
     * @var
     * @ORM\Column(name="content", type="string")
     */
    private $content;


    /**
     * @ORM\Column(name="page_image", type="string" , length=255 , nullable=true)
     */
    private $pageImageName;


    /**
     * @Vich\UploadableField(mapping="user_profile_image", fileNameProperty="pageImageName")
     */
    private $pageImage;

    /**
     * unmapped
     *
     * @var string
     */
    private $pageImageSource;

    /**
     * @var bool
     * @ORM\Column(name="draft",type="boolean")
     */
    private $draft = true;

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
     * @param $date
     */
    public function setJalaliReleaseDate($date)
    {
        $this->jalaliReleaseDate = $date;
    }

    /**
     * @return string
     */
    public function getJalaliReleaseDate()
    {
        return $this->jalaliReleaseDate;
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
    public function setPageImage(File $image = null)
    {
        $this->pageImage = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated_at = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getPageImage()
    {
        return $this->pageImage;
    }


    /**
     * Set pageImageName
     *
     * @param string $pageImageName
     *
     * @return Page
     */
    public function setPageImageName($pageImageName)
    {
        $this->pageImageName = $pageImageName;

        return $this;
    }

    /**
     * Get pageImageName
     *
     * @return string
     */
    public function getPageImageName()
    {
        return $this->pageImageName;
    }


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Page
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
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Page
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set draft
     *
     * @param boolean $draft
     *
     * @return Page
     */
    public function setDraft($draft)
    {
        $this->draft = $draft;

        return $this;
    }

    /**
     * Get draft
     *
     * @return boolean
     */
    public function getDraft()
    {
        return $this->draft;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Page
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
     * @return Page
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
     * @return Page
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
     * @return Page
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
