<?php
// src/Cfp/ConferenceBundle/Entity/Cfp.php

namespace Cfp\ConferenceBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Cfp\ConferenceBundle\Repository\CfpRepository")
 * @ORM\Table(name="cfp")
 */
class Cfp
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

    /**
     * Add conference
     *
     * @param Cfp\ConferenceBundle\Entity\Conference $conference
     */
    public function addConference(\Cfp\ConferenceBundle\Entity\Conference $conference)
    {
        $this->conference[] = $conference;
    }

    /**
     * Add talk
     *
     * @param Cfp\UserBundle\Entity\Talk $talk
     */
    public function addTalk(\Cfp\UserBundle\Entity\Talk $talk)
    {
        $this->talk[] = $talk;
    }
}