<?php

namespace Cfp\ConferenceBundle\Twig;

class cfpStatusExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            'cfp_status'        => new \Twig_Function_Method($this, 'getCfpStatus'),
        );
    }

    public function getCfpStatus(\DateTime $start, \DateTime $end, $add_suffix = false)
    {
        // The current time we compare with
        $now = time();

        // Additional suffix (in case of add_suffix == true)
        $suffix = "";

        // Is the CfP open?
        if ($now > $start->format('U') && $now < $end->format('U')) {
            if ($add_suffix) {
                // Get diff in days between now and the closing
                $suffix = $end->diff(new \DateTime())->days;
                if ($suffix <= 0) {
                    $suffix = "last day!";
                } else {
                    $suffix .= " days remaining until closing";
                }

                $suffix = " (".$suffix.")";
            }
            return "Open".$suffix;
        }

        // Is the CfP not yet opened?
        if ($now < $start->format('U')) {
            if ($add_suffix) {
                // Get diff in days between now and the closing
                $suffix = $start->diff(new \DateTime())->days;
                if ($suffix <= 0) {
                    $suffix = "tomorrow!";
                } else {
                    $suffix .= " days remaining until opening";
                }
                $suffix = " (".$suffix.")";
            }

            return "Not yet open".$suffix;
        }

        // Is the CfP closed?
        if ($now > $end->format('U')) {
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
