<?php
// src/Cfp/UserBundle/Entity/User.php

namespace Cfp\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
     * @ORM\OneToMany(targetEntity="Cfp\CfpBundle\Entity\Cfp", mappedBy="user")
     */
    protected $cfps;

    /**
     * @ORM\ManyToMany(targetEntity="Cfp\ConferenceBundle\Entity\Conference", mappedBy="hosts")
     * @ORM\JoinTable(name="conference_hosts")
     */
    protected $conferences;


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
     * Add cfps
     *
     * @param Cfp\CfpBundle\Entity\Cfp $cfps
     */
    public function addCfp(\Cfp\CfpBundle\Entity\Cfp $cfps)
    {
        $this->cfps[] = $cfps;
    }

    /**
     * Get cfps
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCfps()
    {
        return $this->cfps;
    }

    /**
     * Add conferences
     *
     * @param Cfp\ConferenceBundle\Entity\Conference $conferences
     */
    public function addConference(\Cfp\ConferenceBundle\Entity\Conference $conferences)
    {
        $this->conferences[] = $conferences;
    }

    /**
     * Get conferences
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getConferences()
    {
        return $this->conferences;
    }
}