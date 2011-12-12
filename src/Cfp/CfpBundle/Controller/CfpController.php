<?php

namespace Cfp\CfpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cfp\CfpBundle\Entity\Cfp;
use Cfp\CfpBundle\Form\CfpType;
use \Cfp\ConferenceBundle\Entity\Conference;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

//        $em = $this->getDoctrine()->getEntityManager();
//        $entity = $em->getRepository('CfpCfpBundle:Cfp')->findOneById(1);

//        foreach ($entity->getCfpTalks() as $cfptalk) {
//            print_r($cfptalk->getRemarks());
//            print "<hr>";
//        }
//        exit;
//
        $entities = $user->getCfps();

        return $this->render('CfpCfpBundle:Cfp:index.html.twig', array(
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

        $entity = $em->getRepository('CfpCfpBundle:Cfp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cfp entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CfpCfpBundle:Cfp:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Cfp entity.
     *
     */
    public function newAction($conferencetag)
    {
        $entity = new Cfp();
        $form   = $this->createForm(new CfpType(), $entity);

        $em = $this->getDoctrine()->getEntityManager();
        $conference = $em->getRepository('CfpConferenceBundle:Conference')->findOneByTag($conferencetag);

        if (!$conference) {
            throw $this->createNotFoundException('Unable to find conference.');
        }

        // CFP is not open, we cannot add!
        if ($conference->getCfpStatus() != Conference::OPEN) {
            throw new AccessDeniedHttpException('Conference CFP is closed.');
        }

        return $this->render('CfpCfpBundle:Cfp:new.html.twig', array(
            'entity' => $entity,
            'conference' => $conference,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Cfp entity.
     *
     */
    public function createAction($conferencetag)
    {
        $entity  = new Cfp();
        $request = $this->getRequest();
        $form    = $this->createForm(new CfpType(), $entity);
        $form->bindRequest($request);

        // Fetch conference
        $em = $this->getDoctrine()->getEntityManager();
        $conference = $em->getRepository('CfpConferenceBundle:Conference')->findOneByTag($conferencetag);
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

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('CfpCfpBundle_show_cfp', array('cfp_id' => 1, 'id' => $entity->getId())));
            
        }

        return $this->render('CfpCfpBundle:Cfp:new.html.twig', array(
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

        $entity = $em->getRepository('CfpCfpBundle:Cfp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cfp entity.');
        }

        $editForm = $this->createForm(new CfpType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CfpCfpBundle:Cfp:edit.html.twig', array(
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

        $entity = $em->getRepository('CfpCfpBundle:Cfp')->find($id);

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

            return $this->redirect($this->generateUrl('CfpCfpBundle_show_my_cfps', array('cfp_id' => 1)));
        }

        return $this->render('CfpCfpBundle:Cfp:edit.html.twig', array(
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
            $entity = $em->getRepository('CfpCfpBundle:Cfp')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cfp entity.');
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
