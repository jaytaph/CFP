<?php

namespace Cfp\ConferenceBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;

/**
 * CfpRepository
 *
 */
class CfpRepository extends EntityRepository
{
    function findByOwner(\Cfp\UserBundle\Entity\User $user)
    {
        /*
        --- Get all Cfp's that are owned by the user
        SELECT *
        FROM cfp AS c
        LEFT JOIN talk AS t ON t.id = c.talk_id
        LEFT JOIN talk_owners AS t_o ON t_o.talk_id = t.id
        WHERE t_o.user_id = 2
        */

        // @TODO: This needs to be changed to the Query above!
        return $this->findAll();
    }
}