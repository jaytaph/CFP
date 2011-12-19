<?php

namespace Cfp\CfpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cfp\CfpBundle\Entity\Registration;
use Cfp\CfpBundle\Form\RegistrationType;
use \Cfp\ConferenceBundle\Entity\Conference;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Registration controller.
 *
 */
class RegistrationController extends Controller
{
    /**
     * Lists all registration entities.
     *
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

//        $em = $this->getDoctrine()->getEntityManager();
//        $entity = $em->getRepository('CfpCfpBundle:Registration')->findOneById(1);

//        foreach ($entity->getSubmissions() as $submission) {
//            print_r($submission->getRemarks());
//            print "<hr>";
//        }
//        exit;
//
        $entities = $user->getRegistrations();

        return $this->render('CfpCfpBundle:Registration:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a registration entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpCfpBundle:Registration')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find registration entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CfpCfpBundle:Registration:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new registration entity.
     *
     */
    public function newAction($tag)
    {
        $entity = new Registration();
        $form   = $this->createForm(new RegistrationType(), $entity);

        $em = $this->getDoctrine()->getEntityManager();
        $conference = $em->getRepository('CfpConferenceBundle:Conference')->findOneByTag($tag);

        if (!$conference) {
            throw $this->createNotFoundException('Unable to find conference.');
        }

        // CFP is not open, we cannot add!
        if ($conference->getCfpStatus() != Conference::OPEN) {
            throw new AccessDeniedHttpException('Conference CFP is closed.');
        }

        return $this->render('CfpCfpBundle:Registration:new.html.twig', array(
            'entity' => $entity,
            'conference' => $conference,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Registration entity.
     *
     */
    public function createAction($tag)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        $entity  = new Registration();
        $request = $this->getRequest();
        $form    = $this->createForm(new RegistrationType(), $entity);
        $form->bindRequest($request);

        // Fetch conference
        $em = $this->getDoctrine()->getEntityManager();
        $conference = $em->getRepository('CfpConferenceBundle:Conference')->findOneByTag($tag);
        if (!$conference) {
            throw $this->createNotFoundException('Unable to find conference.');
        }

        // CFP is not open, we cannot add!
        if ($conference->getCfpStatus() != Conference::OPEN) {
            throw new AccessDeniedHttpException('Conference CFP is closed.');
        }

        if ($form->isValid()) {
            // Set correct conference
            $entity->setConference($conference);
            $entity->setUser($currentUser);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            // @TODO: Check if subject should be escaped...
            // Add email to user
            $message = \Swift_Message::newInstance()
                ->setSubject('New CFP registration for ' . $entity->getConference()->getName())
                ->setFrom($this->container->getParameter('emails.contact_email'))
                ->setTo($entity->getUser()->getEmail())
                ->setBody($this->renderView('CfpCfpBundle:Registration:submitEmail.txt.twig', array('entity' => $entity)));
            $this->get('mailer')->send($message);

            // Email to all hosts
            foreach ($entity->getconference()->getHosts() as $host) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('New CFP registration for ' . $entity->getConference()->getName())
                    ->setFrom($this->container->getParameter('emails.contact_email'))
                    ->setTo($host->getEmail())
                    ->setBody($this->renderView('CfpCfpBundle:Registration:submitEmailHost.txt.twig', array('entity' => $entity)));
                $this->get('mailer')->send($message);
            }


            $this->get('session')->setFlash('notice', 'You have registered for CFP submissions!');

            return $this->redirect($this->generateUrl('CfpCfpBundle_show_registration', array('id' => 1, 'id' => $entity->getId())));
            
        }

        return $this->render('CfpCfpBundle:Registration:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Registration entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpCfpBundle:Registration')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find registration entity.');
        }

        $editForm = $this->createForm(new RegistrationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CfpCfpBundle:Registration:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Registration entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpCfpBundle:Registration')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find registration entity.');
        }

        $editForm   = $this->createForm(new RegistrationType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('CfpCfpBundle_show_my_registrations', array('id' => 1)));
        }

        return $this->render('CfpCfpBundle:Registration:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Registration entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CfpCfpBundle:Registration')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find registration entity.');
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
