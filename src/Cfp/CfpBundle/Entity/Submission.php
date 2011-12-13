<?php
// src/Cfp/CfpBundle/Entity/Submission.php

namespace Cfp\CfpBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Cfp\CfpBundle\Repository\SubmissionRepository")
 * @ORM\Table(name="submission")
 */
class Submission
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
     * @ORM\ManyToOne(targetEntity="Cfp\CfpBundle\Entity\Registration", inversedBy="id")
     */
    protected $registration;

    /**
     * @ORM\ManyToOne(targetEntity="Cfp\UserBundle\Entity\Talk")
     */
    protected $talk;

    /**
     * @ORM\Column(type="text", length="1024")
     */
    protected $remarks;

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
     * Set registration
     *
     * @param Cfp\CfpBundle\Entity\Registration $registration
     */
    public function setRegistration(\Cfp\CfpBundle\Entity\Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Get registration
     *
     * @return Cfp\CfpBundle\Entity\Registration 
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * Set talk
     *
     * @param Cfp\UserBundle\Entity\Talk $talk
     */
    public function setTalk(\Cfp\UserBundle\Entity\Talk $talk)
    {
        $this->talk = $talk;
    }

    /**
     * Get talk
     *
     * @return Cfp\UserBundle\Entity\Talk 
     */
    public function getTalk()
    {
        return $this->talk;
    }
}