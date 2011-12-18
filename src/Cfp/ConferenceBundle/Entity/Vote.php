<?php
// src/Cfp/ConferenceBundle/Entity/Vote.php

namespace Cfp\ConferenceBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Cfp\ConferenceBundle\Repository\VoteRepository")
 * @ORM\Table(name="vote")
 * @ORM\HasLifecycleCallbacks()
 */
class Vote
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
     * @ORM\Column(type="datetime")
     */
    protected $dt_created;

    /**
     * @ORM\Column(type="integer")
     */
    protected $vote;

    /**
     * @ORM\Column(type="text")
     */
    protected $remark;

    /**
     * @ORM\ManyToOne(targetEntity="Cfp\UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Cfp\CfpBundle\Entity\Submission")
     */
    protected $submission;


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
     * Set tag
     *
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
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
     * Set vote
     *
     * @param integer $vote
     */
    public function setVote($vote)
    {
        $this->vote = $vote;
    }

    /**
     * Get vote
     *
     * @return integer 
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set remark
     *
     * @param text $remark
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    }

    /**
     * Get remark
     *
     * @return text 
     */
    public function getRemark()
    {
        return $this->remark;
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
     * Set submission
     *
     * @param Cfp\CfpBundle\Entity\Submission $submission
     */
    public function setSubmission(\Cfp\CfpBundle\Entity\Submission $submission)
    {
        $this->submission = $submission;
    }

    /**
     * Get submission
     *
     * @return Cfp\CfpBundle\Entity\Submission 
     */
    public function getSubmission()
    {
        return $this->submission;
    }
}