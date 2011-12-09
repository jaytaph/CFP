<?php

namespace Cfp\ConferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ivory\GoogleMapBundle\Model\MapTypeId;
use Ivory\GoogleMapBundle\Model\Overlays\Animation;


class DefaultController extends Controller
{
    
    public function showAction($tag)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $conference = $em->getRepository('CfpConferenceBundle:Conference')->findOneByTag($tag);
        if (!$conference) {
            throw $this->createNotFoundException('Unable to find this conference.');
        }

        // Requests the ivory google map marker service
        $marker = $this->get('ivory_google_map.marker');

        // Configure your marker options
        $marker->setPrefixJavascriptVariable('marker_');
        $marker->setPosition($conference->getGeoLat(), $conference->getGeoLong(), true);
        $marker->setAnimation(Animation::DROP);

        $marker->setOption('clickable', true);
        $marker->setOption('flat', true);



        // Requests the ivory google map service
        $map = $this->get('ivory_google_map.map');
        $map->setPrefixJavascriptVariable('map_');
        $map->setHtmlContainerId('map_canvas');
        $map->setCenter($conference->getGeoLat(), $conference->getGeoLong(), true);
        $map->setMapOption('zoom', 16);
        $map->setMapOption('mapTypeId', MapTypeId::HYBRID);
        $map->setStylesheetOptions(array('width' => '300px', 'height' => '300px'));

        $map->addMarker($marker);

        return $this->render('CfpConferenceBundle:Default:show.html.twig', array(
            'conference'  => $conference,
            'map'         => $map,
        ));
    }

    public function showAllAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        // Just like a findAll() but with an orderBy()
        $conferences = $em->getRepository('CfpConferenceBundle:Conference')->findBy(array(), array('dt_start' => 'ASC'));;

        return $this->render('CfpConferenceBundle:Default:showall.html.twig', array(
            'conferences' => $conferences,
        ));
    }

}
