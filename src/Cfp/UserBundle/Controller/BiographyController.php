<?php

namespace Cfp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cfp\UserBundle\Form\BiographyType;
use Cfp\UserBundle\Entity\Biography;


class BiographyController extends Controller
{

    function showAllFromUserAction()
    {
        // Fetch current logged in user
        $user = $this->get('security.context')->getToken()->getUser();

        return $this->render('CfpUserBundle:Biography:showall.html.twig', array(
            'biographies' => $user->getBiographies(),
        ));
    }

    function showAction($id)
    {
        // @TODO: Only the user and a "conference host" to which this user has submitted a talk to, can view

        $em = $this->getDoctrine()->getEntityManager();
        $biography = $em->getRepository('CfpUserBundle:Biography')->findOneById($id);
        if (!$biography) {
            throw $this->createNotFoundException('Unable to find this biography.');
        }

        // Fetch current logged in user
        $user = $this->get('security.context')->getToken()->getUser();
        if ($biography->getOwner() != $user) {
            throw $this->createNotFoundException('Unable to access this biography.');
        }


        return $this->render('CfpUserBundle:Biography:show.html.twig', array(
            'biography'  => $biography,
        ));
    }

    function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $biography = $em->getRepository('CfpUserBundle:Biography')->findOneById($id);
        if (!$biography) {
            throw $this->createNotFoundException('Unable to find this biography.');
        }

        // Fetch current logged in user
        $user = $this->get('security.context')->getToken()->getUser();
        if ($biography->getOwner() != $user) {
            throw $this->createNotFoundException('Unable to access this biography.');
        }

        return $this->_mutate($biography, 'edit');
    }

    function addAction()
    {
        $biography = new Biography();

        // Set owner of the biography the currently logged in user
        $user = $this->get('security.context')->getToken()->getUser();
        $biography->setOwner($user);

        return $this->_mutate($biography, 'add');
    }

    protected function _mutate(Biography $biography, $type = "add")
    {
        if ($type != "add" && $type != "edit") {
            throw new \UnexpectedValueException("Mutation type should be either 'add' or 'edit' but found '".$type."'");
        }

        // Create form based on biography
        $form = $this->createForm(new BiographyType(), $biography);

        // Fetch request
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            // Bind the request data to our form
            $form->bindRequest($request);

            if ($form->isValid()) {
                // Save biography
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($biography);
                $em->flush();

                if ($type == "add") {
                    $this->get('session')->setFlash('notice', 'A new biography has been created!');
                } else {
                    $this->get('session')->setFlash('notice', 'Biography has been updated!');
                }

                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('CfpUserBundle_show_my_biographies'));
            }
        }

        return $this->render('CfpUserBundle:Biography:form.html.twig', array(
            'form' => $form->createView(),
            'mutation_type' => $type,
            'biography' => $biography,
        ));
    }
}
