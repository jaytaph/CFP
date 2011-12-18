<?php

namespace Cfp\ConferenceBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * VoteRepository
 *
 */
class VoteRepository extends EntityRepository
{

    public function findVotes()
    {
        // @TODO: Create SQL that will find all votes concerning this conference
//        $qb = $this->createQueryBuilder('c')
//                   ->select('c')
//                   ->where('c.cfp_start >= :now')
//                   ->addOrderBy('c.cfp_start', 'DESC')
//                   ->setMaxResults($limit);
//
//        $qb->setParameter('now', date('Y-m-d H:i:s'));
//
//        return $qb->getQuery()
//                  ->getResult();
    }

}