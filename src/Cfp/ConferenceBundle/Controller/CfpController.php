<?php

namespace Cfp\ConferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cfp\ConferenceBundle\Entity\Cfp;
use Cfp\ConferenceBundle\Form\CfpType;

/**
 * Cfp controller.
 *
 */
class CfpController extends Controller
{
    /**
     * Lists all Cfp entities.
     *
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('CfpConferenceBundle:Cfp')->findByOwner($user);

        return $this->render('CfpConferenceBundle:Cfp:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Cfp entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpConferenceBundle:Cfp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cfp entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CfpConferenceBundle:Cfp:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Cfp entity.
     *
     */
    public function newAction()
    {
        $entity = new Cfp();
        $form   = $this->createForm(new CfpType(), $entity);

        return $this->render('CfpConferenceBundle:Cfp:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Cfp entity.
     *
     */
    public function createAction()
    {
        $entity  = new Cfp();
        $request = $this->getRequest();
        $form    = $this->createForm(new CfpType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('CfpConferenceBundle_show_registration', array('id' => $entity->getId())));
            
        }

        return $this->render('CfpConferenceBundle:Cfp:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Cfp entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpConferenceBundle:Cfp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cfp entity.');
        }

        $editForm = $this->createForm(new CfpType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CfpConferenceBundle:Cfp:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Cfp entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpConferenceBundle:Cfp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cfp entity.');
        }

        $editForm   = $this->createForm(new CfpType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('CfpConferenceBundle_edit_registration', array('id' => $id)));
        }

        return $this->render('CfpConferenceBundle:Cfp:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Cfp entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CfpConferenceBundle:Cfp')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cfp entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('CfpConferenceBundle_show_my_registrations'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
