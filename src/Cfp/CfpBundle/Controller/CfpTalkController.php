<?php

namespace Cfp\CfpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cfp\CfpBundle\Entity\CfpTalk;
use Cfp\CfpBundle\Form\CfpTalkType;

/**
 * CfpTalk controller.
 *
 */
class CfpTalkController extends Controller
{
    /**
     * Lists all CfpTalk entities.
     *
     */
    public function indexAction($cfp_id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('CfpCfpBundle:CfpTalk')->findByCfp($cfp_id);

        $cfp = $em->getRepository('CfpCfpBundle:Cfp')->find($cfp_id);

        return $this->render('CfpCfpBundle:CfpTalk:index.html.twig', array(
            'entities' => $entities,
            'cfp' => $cfp,
        ));
    }

    /**
     * Finds and displays a CfpTalk entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpCfpBundle:CfpTalk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CfpTalk entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CfpCfpBundle:CfpTalk:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new CfpTalk entity.
     *
     */
    public function newAction($cfp_id)
    {
        $entity = new CfpTalk();
        $form   = $this->createForm(new CfpTalkType(), $entity);

        $em = $this->getDoctrine()->getEntityManager();
        $cfp = $em->getRepository('CfpCfpBundle:Cfp')->find($cfp_id);

        return $this->render('CfpCfpBundle:CfpTalk:new.html.twig', array(
            'entity' => $entity,
            'cfp' => $cfp,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new CfpTalk entity.
     *
     */
    public function createAction($cfp_id)
    {
        $entity  = new CfpTalk();
        $request = $this->getRequest();
        $form    = $this->createForm(new CfpTalkType(), $entity);
        $form->bindRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        $cfp = $em->getRepository('CfpCfpBundle:Cfp')->find($cfp_id);
        if (! $cfp instanceof \Cfp\CfpBundle\Entity\Cfp) {
            throw new \Symfony\Component\Form\Exception\CreationException("Cannot find the CFP to bind our talk to.");
        }
        $entity->setCfp($cfp);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            // @TODO: Check if subject should be escaped...
            // Add email to user
            $message = \Swift_Message::newInstance()
                ->setSubject('New talk submitted to ' . $entity->getCfp()->getConference()->getName())
                ->setFrom($this->container->getParameter('emails.contact_email'))
                ->setTo($entity->getCfp()->GetUser()->getEmail())
                ->setBody($this->renderView('CfpCfpBundle:CfpTalk:submitEmail.txt.twig', array('entity' => $entity, 'cfp' => $cfp, 'talk' => $entity->getTalk())));
            $this->get('mailer')->send($message);

            $this->get('session')->setFlash('notice', 'Your talk has been submitted!');

            return $this->redirect($this->generateUrl('CfpCfpBundle_show_my_cfp_talks', array('cfp_id' => 1)));
            
        }

        return $this->render('CfpCfpBundle:CfpTalk:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing CfpTalk entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpCfpBundle:CfpTalk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CfpTalk entity.');
        }

        $editForm = $this->createForm(new CfpTalkType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CfpCfpBundle:CfpTalk:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing CfpTalk entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpCfpBundle:CfpTalk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CfpTalk entity.');
        }

        $editForm   = $this->createForm(new CfpTalkType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('CfpCfpBundle_edit_cfp_talk', array('cfp_id' => 1, 'id' => $id)));
        }

        return $this->render('CfpCfpBundle:CfpTalk:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CfpTalk entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CfpCfpBundle:CfpTalk')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CfpTalk entity.');
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
