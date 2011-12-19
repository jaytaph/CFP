<?php

namespace Cfp\ConferenceBundle\Twig;
use \Cfp\ConferenceBundle\Entity\Conference;

class cfpStatusExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            'cfp_status'        => new \Twig_Function_Method($this, 'getCfpStatus'),
            'cfp_is_open'        => new \Twig_Function_Method($this, 'isCfpOpen'),
        );
    }

    public function isCfpOpen(Conference $conference) {
        return ($conference->getCfpStatus() == Conference::OPEN);
    }

    public function getCfpStatus(\Cfp\ConferenceBundle\Entity\Conference $conference, $add_suffix = false)
    {
        $status = $conference->getCfpStatus();

        // Additional suffix (in case of add_suffix == true)
        $suffix = "";

        // Is the CfP open?
        if ($status == Conference::OPEN) {
            if ($add_suffix) {
                // Get diff in days between now and the closing
                $suffix = $conference->getCfpEnd()->diff(new \DateTime())->days;
                if ($suffix <= 0) {
                    $suffix = "last day!";
                } else {
                    $suffix .= " days";
                }

                $suffix = " (".$suffix.")";
            }
            return "Open".$suffix;
        }

        // Is the CfP not yet opened?
        if ($status == Conference::PENDING) {
            if ($add_suffix) {
                // Get diff in days between now and the closing
                $suffix = $conference->getCfpStart()->diff(new \DateTime())->days;
                if ($suffix <= 0) {
                    $suffix = "tomorrow!";
                } else {
                    $suffix .= " days";
                }
                $suffix = " (".$suffix.")";
            }

            return "Not yet open".$suffix;
        }

        // Is the CfP closed?
        if ($status == Conference::CLOSED) {
            return "Closed";
        }

        // Some other status? That is not possible!
        return "Unknown";
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cfpStatus';
    }
}
