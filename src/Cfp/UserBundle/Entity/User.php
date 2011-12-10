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
}