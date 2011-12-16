<?php

namespace Cfp\ConferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cfp\ConferenceBundle\Form\ConferenceType;
use Cfp\ConferenceBundle\Entity\Conference;
use Symfony\Component\HttpFoundation\Request;

class HostController extends Controller
{
    public function showAction($tag)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $conference = $em->getRepository('CfpConferenceBundle:Conference')->findOneByTag($tag);
        if (!$conference) {
            throw $this->createNotFoundException('Unable to find this conference.');
        }

        return $this->render('CfpConferenceBundle:Host:show.html.twig', array(
            'conference'  => $conference,
        ));
    }
}