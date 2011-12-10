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
        $qb = $this->createQueryBuilder('c')
                   ->select('c')
                   ->addOrderBy('c.dt_created', 'DESC')
                   ->setMaxResults($limit);

        return $qb->getQuery()
                  ->getResult();
    }

    public function getNextByCfp($limit = 15)
    {
        $qb = $this->createQueryBuilder('c')
                   ->select('c')
                   ->where('c.cfp_start >= :now')
                   ->addOrderBy('c.cfp_start', 'DESC')
                   ->setMaxResults($limit);

        $qb->setParameter('now', date('Y-m-d H:i:s'));

        return $qb->getQuery()
                  ->getResult();
    }

    /**
     * Returns all conferences with currently open CFP's
     * @param int $limit
     * @return array
     */
    public function getOpenCfps($limit = 15)
    {
        $qb = $this->createQueryBuilder('c')
                   ->select('c')
                   ->where('c.cfp_start <= :now')
                   ->andWhere('c.cfp_end >= :now')
                   ->addOrderBy('c.cfp_start', 'DESC')
                   ->setMaxResults($limit);

        $qb->setParameter('now', date('Y-m-d H:i:s'));

        return $qb->getQuery()
                  ->getResult();
    }

}