<?php

namespace Cfp\ConferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ivory\GoogleMapBundle\Model\MapTypeId;
use Ivory\GoogleMapBundle\Model\Overlays\Animation;
use Cfp\ConferenceBundle\Form\ConferenceType;
use Cfp\ConferenceBundle\Entity\Conference;


class ConferenceController extends Controller
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

        return $this->render('CfpConferenceBundle:Conference:show.html.twig', array(
            'conference'  => $conference,
            'map'         => $map,
        ));
    }

    public function showAllAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        // Just like a findAll() but with an orderBy()
        $conferences = $em->getRepository('CfpConferenceBundle:Conference')->findBy(array(), array('dt_start' => 'ASC'));;

        return $this->render('CfpConferenceBundle:Conference:index.html.twig', array(
            'conferences' => $conferences,
            'partial' => 'CfpConferenceBundle:Conference:partial_all.html.twig',
            'addLink' => true,
        ));
    }

    public function showCfpAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $conferences = $em->getRepository('CfpConferenceBundle:Conference')->getOpenCfps();

        return $this->render('CfpConferenceBundle:Conference:index.html.twig', array(
            'conferences' => $conferences,
            'partial' => 'CfpConferenceBundle:Conference:partial_opencfp.html.twig',
        ));
    }

    public function showNextOpenCfpAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $conferences = $em->getRepository('CfpConferenceBundle:Conference')->getNextByCfp();

        return $this->render('CfpConferenceBundle:Conference:index.html.twig', array(
            'conferences' => $conferences,
            'partial' => 'CfpConferenceBundle:Conference:partial_pending.html.twig',
        ));
    }

    public function showUserConferencesAction() {
        $user = $this->get('security.context')->getToken()->getUser();

        $conferences = $user->getConferencesHost();

        return $this->render('CfpConferenceBundle:Conference:index.html.twig', array(
            'conferences' => $conferences,
            'partial' => 'CfpConferenceBundle:Conference:partial_my.html.twig',
            'addLink' => true,
        ));
    }



    /**
     * Displays a form to create a new Conference entity.
     *
     */
    public function newAction()
    {
        $entity = new Conference();
        $form   = $this->createForm(new ConferenceType(), $entity);

        return $this->render('CfpConferenceBundle:Conference:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Conference entity.
     *
     */
    public function createAction()
    {
        $entity  = new Conference();
        $request = $this->getRequest();
        $form    = $this->createForm(new ConferenceType(), $entity);
        $form->bindRequest($request);

        $user = $this->get('security.context')->getToken()->getUser();
        $entity->addAdmin($user);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            // @TODO Add flash notice

            return $this->redirect($this->generateUrl('CfpConferenceBundle_show_my_conferences'));

        }

        return $this->render('CfpConferenceBundle:Conference:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Conference entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpConferenceBundle:Conference')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find conference entity.');
        }

        $editForm = $this->createForm(new ConferenceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CfpConferenceBundle:Conference:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Conference entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpConferenceBundle:Conference')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find conference entity.');
        }

        $editForm   = $this->createForm(new ConferenceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('CfpConferenceBundle_edit_conference', array('id' => $id)));
        }

        return $this->render('CfpConferenceBundle:Conference:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Conference entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CfpConferenceBundle:Conference')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find conference entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('CfpConferenceBundle_show_my_conferences'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

}
