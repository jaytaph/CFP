<?php
// src/Cfp/UserBundle/Entity/Biography.php

namespace Cfp\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Cfp\ConferenceBundle\Repository\ConferenceRepository")
 * @ORM\Table(name="biography")
 */
class Biography
{

    public function __construct()
    {
        $this->setDtAdded(new \DateTime());

        // @TODO: Lifecycle, when updated, update this date as well
        $this->setDtUpdated(new \DateTime());
    }

    function __toString() {
        return $this->getDescription();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cfp\UserBundle\Entity\User", inversedBy="id")
     */
    protected $owner;

    /**
     * @ORM\Column(type="string", length="50")
     */
    protected $description;

    /**
     * @ORM\Column(type="text")
     */
    protected $biography;

    // @TODO: Let user upload photo to the biography?

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dt_added;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dt_updated;

    /**
     * @ORM\Column(type="string", length="250")
     */
    protected $joindin_url;

    /**
     * @ORM\Column(type="string", length="250")
     */
    protected $slideshare_url;

    /**
     * @ORM\Column(type="string", length="250")
     */
    protected $blog_url;

    /**
     * @ORM\Column(type="string", length="250")
     */
    protected $homepage_url;


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
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set biography
     *
     * @param text $biography
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;
    }

    /**
     * Get biography
     *
     * @return text 
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Set dt_added
     *
     * @param datetime $dtAdded
     */
    public function setDtAdded($dtAdded)
    {
        $this->dt_added = $dtAdded;
    }

    /**
     * Get dt_added
     *
     * @return datetime 
     */
    public function getDtAdded()
    {
        return $this->dt_added;
    }

    /**
     * Set dt_updated
     *
     * @param datetime $dtUpdated
     */
    public function setDtUpdated($dtUpdated)
    {
        $this->dt_updated = $dtUpdated;
    }

    /**
     * Get dt_updated
     *
     * @return datetime 
     */
    public function getDtUpdated()
    {
        return $this->dt_updated;
    }

    /**
     * Set joindin_url
     *
     * @param string $joindinUrl
     */
    public function setJoindinUrl($joindinUrl)
    {
        $this->joindin_url = $joindinUrl;
    }

    /**
     * Get joindin_url
     *
     * @return string 
     */
    public function getJoindinUrl()
    {
        return $this->joindin_url;
    }

    /**
     * Set slideshare_url
     *
     * @param string $slideshareUrl
     */
    public function setSlideshareUrl($slideshareUrl)
    {
        $this->slideshare_url = $slideshareUrl;
    }

    /**
     * Get slideshare_url
     *
     * @return string 
     */
    public function getSlideshareUrl()
    {
        return $this->slideshare_url;
    }

    /**
     * Set blog_url
     *
     * @param string $blogUrl
     */
    public function setBlogUrl($blogUrl)
    {
        $this->blog_url = $blogUrl;
    }

    /**
     * Get blog_url
     *
     * @return string 
     */
    public function getBlogUrl()
    {
        return $this->blog_url;
    }

    /**
     * Set homepage_url
     *
     * @param string $homepageUrl
     */
    public function setHomepageUrl($homepageUrl)
    {
        $this->homepage_url = $homepageUrl;
    }

    /**
     * Get homepage_url
     *
     * @return string 
     */
    public function getHomepageUrl()
    {
        return $this->homepage_url;
    }

    /**
     * Set owner
     *
     * @param Cfp\UserBundle\Entity\User $owner
     */
    public function setOwner(\Cfp\UserBundle\Entity\User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * Get owner
     *
     * @return Cfp\UserBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }
}