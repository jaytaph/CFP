<?php
// src/Cfp/CfpBundle/Entity/CfpTalk.php

namespace Cfp\CfpBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Cfp\CfpBundle\Repository\CfpTalkRepository")
 * @ORM\Table(name="cfptalk")
 */
class CfpTalk
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
     * @ORM\ManyToOne(targetEntity="Cfp\CfpBundle\Entity\Cfp", inversedBy="id")
     */
    protected $cfp;

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
     * Set cfp
     *
     * @param Cfp\CfpBundle\Entity\Cfp $cfp
     */
    public function setCfp(\Cfp\CfpBundle\Entity\Cfp $cfp)
    {
        $this->cfp = $cfp;
    }

    /**
     * Get cfp
     *
     * @return Cfp\CfpBundle\Entity\Cfp 
     */
    public function getCfp()
    {
        return $this->cfp;
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