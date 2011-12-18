<?php
// src/Cfp/CfpBundle/Entity/Registration.php

namespace Cfp\CfpBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Cfp\CfpBundle\Repository\RegistrationRepository")
 * @ORM\Table(name="registration")
 */
class Registration
{
    public function __construct()
    {
        $this->setDtCreated(new \DateTime());
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cfp\ConferenceBundle\Entity\Conference")
     */
    protected $conference;

    /**
     * @ORM\ManyToOne(targetEntity="Cfp\UserBundle\Entity\User", inversedBy="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Cfp\UserBundle\Entity\Biography", inversedBy="id")
     */
    protected $biography;


    /**
     * @ORM\Column(type="text", length="1024")
     */
    protected $remarks;

    /**
     * @ORM\OneToMany(targetEntity="Cfp\CfpBundle\Entity\Submission", mappedBy="registration")
     */
    protected $submissions;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dt_created;


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
     * Set remarks
     *
     * @param text $remarks
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;
    }

    /**
     * Get remarks
     *
     * @return text 
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set dt_created
     *
     * @param datetime $dtCreated
     */
    public function setDtCreated($dtCreated)
    {
        $this->dt_created = $dtCreated;
    }

    /**
     * Get dt_created
     *
     * @return datetime 
     */
    public function getDtCreated()
    {
        return $this->dt_created;
    }

    /**
     * Set conference
     *
     * @param Cfp\ConferenceBundle\Entity\Conference $conference
     */
    public function setConference(\Cfp\ConferenceBundle\Entity\Conference $conference)
    {
        $this->conference = $conference;
    }

    /**
     * Get conference
     *
     * @return Cfp\ConferenceBundle\Entity\Conference 
     */
    public function getConference()
    {
        return $this->conference;
    }

    /**
     * Set user
     *
     * @param Cfp\UserBundle\Entity\User $user
     */
    public function setUser(\Cfp\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Cfp\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set biography
     *
     * @param Cfp\UserBundle\Entity\Biography $biography
     */
    public function setBiography(\Cfp\UserBundle\Entity\Biography $biography)
    {
        $this->biography = $biography;
    }

    /**
     * Get biography
     *
     * @return Cfp\UserBundle\Entity\Biography 
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Add submissions
     *
     * @param Cfp\CfpBundle\Entity\Submission $submissions
     */
    public function addSubmussion(\Cfp\CfpBundle\Entity\Submission $submissions)
    {
        $this->submissions[] = $submissions;
    }

    /**
     * Get submissions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSubmissions()
    {
        return $this->submissions;
    }

    /**
     * Add submissions
     *
     * @param Cfp\CfpBundle\Entity\Submission $submissions
     */
    public function addSubmission(\Cfp\CfpBundle\Entity\Submission $submissions)
    {
        $this->submissions[] = $submissions;
    }
}