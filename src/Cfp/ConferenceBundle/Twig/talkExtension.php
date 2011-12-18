<?php

namespace Cfp\ConferenceBundle\Twig;
use \Cfp\ConferenceBundle\Entity\Conference;

class talkExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            'talk_print_owners'        => new \Twig_Function_Method($this, 'printOwners'),
        );
    }

    public function printOwners(\Cfp\UserBundle\Entity\Talk $talk) {
        $owners = array();
        foreach ($talk->getOwners() as $owner) {
            $owners[] = $owner->getUsername();
        }
        return implode(" & ", $owners);
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'talk';
    }
}
