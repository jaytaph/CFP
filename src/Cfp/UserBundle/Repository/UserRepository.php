<?php

namespace Cfp\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\Collection;

/**
 * UserRepository
 *
 */
class UserRepository extends EntityRepository
{
    // @TODO: We could do this through an SQL query
    function findAllExceptAdmins(\Cfp\ConferenceBundle\Entity\Conference $conference) {
        $it = new \ArrayIterator($this->findAll());
        $it = new ConferenceUserFilter($it, $conference->getAdmins());
        return iterator_to_array($it);
    }

    function findAllExceptHosts(\Cfp\ConferenceBundle\Entity\Conference $conference) {

        $it = new \ArrayIterator($this->findAll());
        $it = new ConferenceUserFilter($it, $conference->getHosts());
        return iterator_to_array($it);
    }
}


// @TODO: Remove this Create iterator filter that filters our items based on a collection
class ConferenceUserFilter extends \FilterIterator
{
    protected $_collection;

    function __construct(\Iterator $it, Collection $collection) {
        parent::__construct($it);

        $this->_collection = $collection;
    }

    function accept() {
        $currentUser = $this->current();

        if ($this->_collection->exists(
            function($key, $user) use($currentUser) {
                return ($currentUser == $user);
            }
        )) return false;
        return true;
    }

    function key() {
        return $this->current()->getUserName();
    }
}

