<?php
// src/Cfp/UserBundle/Entity/User.php

namespace Cfp\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Cfp\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Cfp\UserBundle\Entity\Biography", mappedBy="owner")
     */
    protected $biographies;

    /**
     * @ORM\OneToMany(targetEntity="Cfp\CfpBundle\Entity\Registration", mappedBy="user")
     */
    protected $registrations;

    /**
     * @ORM\ManyToMany(targetEntity="Cfp\ConferenceBundle\Entity\Conference", mappedBy="hosts")
     * @ORM\JoinTable(name="conference_hosts")
     */
    protected $conferences_host;

    /**
     * @ORM\ManyToMany(targetEntity="Cfp\ConferenceBundle\Entity\Conference", mappedBy="admins")
     * @ORM\JoinTable(name="conference_admins")
     */
    protected $conferences_admin;


    public function __construct()
    {
        parent::__construct();
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
     * Add biographies
     *
     * @param Cfp\UserBundle\Entity\Biography $biographies
     */
    public function addBiography(\Cfp\UserBundle\Entity\Biography $biographies)
    {
        $this->biographies[] = $biographies;
    }

    /**
     * Get biographies
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getBiographies()
    {
        return $this->biographies;
    }

    /**
     * Add registrations
     *
     * @param Cfp\CfpBundle\Entity\Registration $registrations
     */
    public function addRegistration(\Cfp\CfpBundle\Entity\Registration $registrations)
    {
        $this->registrations[] = $registrations;
    }

    /**
     * Get registrations
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRegistrations()
    {
        return $this->registrations;
    }

    /**
     * Get conferences_host
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getConferencesHost()
    {
        return $this->conferences_host;
    }

    /**
     * Get conferences_admin
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getConferencesAdmin()
    {
        return $this->conferences_admin;
    }

    /**
     * Add conferences_host
     *
     * @param Cfp\ConferenceBundle\Entity\Conference $conferencesHost
     */
    public function addConference(\Cfp\ConferenceBundle\Entity\Conference $conferencesHost)
    {
        $this->conferences_host[] = $conferencesHost;
    }
}