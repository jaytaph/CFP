<?php
// src/Cfp/UserBundle/Entity/Talk.php

namespace Cfp\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="talk")
 */
class Talk
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Cfp\UserBundle\Entity\User", inversedBy="talks", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="talk_owners")
     */
    protected $owners;

    /**
     * @ORM\Column(type="string", length="100")
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $abstract;

    /**
     * @ORM\Column(type="string", length="50")
     */
    protected $type;

    /**
     * @ORM\Column(type="string", length="250")
     */
    protected $slides_url;

    /**
     * @ORM\Column(type="string", length="250")
     */
    protected $joindin_url;

    public function __construct()
    {
        $this->owners = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * Set abstract
     *
     * @param string $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * Get abstract
     *
     * @return string 
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set slides_url
     *
     * @param string $slidesUrl
     */
    public function setSlidesUrl($slidesUrl)
    {
        $this->slides_url = $slidesUrl;
    }

    /**
     * Get slides_url
     *
     * @return string 
     */
    public function getSlidesUrl()
    {
        return $this->slides_url;
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
     * Add owners
     *
     * @param Cfp\UserBundle\Entity\User $owners
     */
    public function addUser(\Cfp\UserBundle\Entity\User $owners)
    {
        $this->owners[] = $owners;
    }

    /**
     * Get owners
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOwners()
    {
        return $this->owners;
    }
}