<?php

namespace Cfp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cfp\UserBundle\Entity\Talk;
use Cfp\UserBundle\Form\TalkType;

/**
 * Talk controller.
 *
 */
class TalkController extends Controller
{
    /**
     * Lists all Talk entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('CfpUserBundle:Talk')->findAll();

        return $this->render('CfpUserBundle:Talk:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Talk entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpUserBundle:Talk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Talk entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CfpUserBundle:Talk:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Talk entity.
     *
     */
    public function newAction()
    {
        $entity = new Talk();
        $form   = $this->createForm(new TalkType(), $entity);

        return $this->render('CfpUserBundle:Talk:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Talk entity.
     *
     */
    public function createAction()
    {
        $entity  = new Talk();
        $request = $this->getRequest();
        $form    = $this->createForm(new TalkType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('CfpUserBundle_show_talk', array('id' => $entity->getId())));
            
        }

        return $this->render('CfpUserBundle:Talk:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Talk entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpUserBundle:Talk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Talk entity.');
        }

        $editForm = $this->createForm(new TalkType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CfpUserBundle:Talk:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Talk entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('CfpUserBundle:Talk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Talk entity.');
        }

        $editForm   = $this->createForm(new TalkType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('CfpUserBundle_edit_talk', array('id' => $id)));
        }

        return $this->render('CfpUserBundle:Talk:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Talk entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('CfpUserBundle:Talk')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Talk entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('CfpUserBundle_show_my_talks'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
