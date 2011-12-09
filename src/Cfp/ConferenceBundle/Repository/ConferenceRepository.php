<?php

namespace Cfp\ConferenceBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ConferenceRepository
 *
 */
class ConferenceRepository extends EntityRepository
{

    public function getLatest($limit = 15)
    {
        $qb = $this->createQueryBuilder('b')
                   ->select('b')
                   ->addOrderBy('b.dt_created', 'DESC')
                   ->setMaxResults($limit);

        return $qb->getQuery()
                  ->getResult();
    }

}