<?php

namespace Cfp\CfpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cfp\CfpBundle\Entity\Submission;
use Cfp\CfpBundle\Form\SubmissionType;

/**
 * Submission controller.
 *
 */
class SubmissionController extends Controller
{
    /**
     * Lists all submission entities.
     *
     */
    public function indexAction($registration_id)
    {
        $em = $this->getDoctrine()->getEntityManager();
//        $entities = $em->getRepository('CfpCfpBundle:Submission')->findByRegistration($registration_id);
        $registration = $em->getRepository('CfpCfpBundle:Submission')->find($registration_id);

        return $this->render('CfpCfpBundle:Submission:index.html.twig', array(
            'registration' => $registration,
        ));
    }

    /**
     * Finds and displays a submission entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpCfpBundle:Submission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find submission entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CfpCfpBundle:Submission:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new submission entity.
     *
     */
    public function newAction($registration_id)
    {
        $entity = new Submission();
        $form   = $this->createForm(new SubmissionType(), $entity);

        $em = $this->getDoctrine()->getEntityManager();
        $registration = $em->getRepository('CfpCfpBundle:Registration')->find($registration_id);

        return $this->render('CfpCfpBundle:Submission:new.html.twig', array(
            'entity' => $entity,
            'registration' => $registration,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Submission entity.
     *
     */
    public function createAction($registration_id)
    {
        $entity  = new Submission();
        $request = $this->getRequest();
        $form    = $this->createForm(new SubmissionType(), $entity);
        $form->bindRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        $registration = $em->getRepository('CfpCfpBundle:Registration')->find($registration_id);
        if (! $registration instanceof \Cfp\CfpBundle\Entity\Registration) {
            throw new \Symfony\Component\Form\Exception\CreationException("Cannot find the registration to bind our talk to.");
        }
        $entity->setRegistration($registration);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            // @TODO: Check if subject should be escaped...
            // Add email to user
            $message = \Swift_Message::newInstance()
                ->setSubject('New talk submitted to ' . $entity->getRegistration()->getConference()->getName())
                ->setFrom($this->container->getParameter('emails.contact_email'))
                ->setTo($entity->getRegistration()->GetUser()->getEmail())
                ->setBody($this->renderView('CfpCfpBundle:Submission:submitEmail.txt.twig', array('entity' => $entity)));
            $this->get('mailer')->send($message);

            $this->get('session')->setFlash('notice', 'Your talk has been submitted!');

            // @TODO: Hardcoded registration ID!
            return $this->redirect($this->generateUrl('CfpCfpBundle_show_my_submissions', array('registration_id' => 1)));
            
        }

        return $this->render('CfpCfpBundle:Submission:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing submission entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpCfpBundle:Submission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find submission entity.');
        }

        $editForm = $this->createForm(new SubmissionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CfpCfpBundle:Submission:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing submission entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpCfpBundle:Submission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find submission entity.');
        }

        $editForm   = $this->createForm(new SubmissionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            // @TODO: Flash banner

            return $this->redirect($this->generateUrl('CfpCfpBundle_edit_submission', array('registration_id' => $entity->getRegistration()->getId(), 'id' => $id)));
        }

        return $this->render('CfpCfpBundle:Submission:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a submission entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CfpCfpBundle:Submission')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find submission entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl(''));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
