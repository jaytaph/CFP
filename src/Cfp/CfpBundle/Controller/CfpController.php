<?php

namespace Cfp\CfpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Cfp\CfpBundle\Entity\Cfp;
use Cfp\CfpBundle\Form\CfpType;

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
    public function newAction()
    {
        $entity = new Cfp();
        $form   = $this->createForm(new CfpType(), $entity);

        return $this->render('CfpCfpBundle:Cfp:new.html.twig', array(
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

            return $this->redirect($this->generateUrl('CfpCfpBundle_show_my_cfp_talk', array('cfp_id' => 1, 'id' => $entity->getId())));
            
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

            return $this->redirect($this->generateUrl('CfpCfpBundle_edit_my_cfp_talks', array('cfp_id' => 1, 'id' => $id)));
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
