<?php

namespace Cfp\ConferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Cfp\ConferenceBundle\Form\ConferenceType;
use Cfp\ConferenceBundle\Entity\Conference;
use Symfony\Component\HttpFoundation\Request;

// @TODO: One should not be here when we are not logged in

class AdminController extends Controller
{
    public function showAction($tag)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $conference = $em->getRepository('CfpConferenceBundle:Conference')->findOneByTag($tag);
        if (!$conference) {
            throw $this->createNotFoundException('Unable to find this conference.');
        }

        // Generate forms
        $admin_form = $this->_getAdminForm($conference);
        $host_form = $this->_getHostForm($conference);

        return $this->render('CfpConferenceBundle:Admin:show.html.twig', array(
            'conference'  => $conference,
            'admin_form' => $admin_form->createView(),
            'host_form' => $host_form->createView(),
        ));
    }

    public function removeAdminAction($tag)
    {
        return $this->_postMutateUser($tag, "admin", "remove");
    }

    public function removeHostAction($tag)
    {
        return $this->_postMutateUser($tag, "host", "remove");
    }

    public function addHostAction($tag)
    {
        return $this->_postMutateUser($tag, "host", "add");
    }

    public function addAdminAction($tag, Request $request)
    {
        return $this->_postMutateUser($tag, "admin", "add");
    }




    // Generate admin dropdown without the current admins for the conference
    protected function _getAdminForm(\Cfp\ConferenceBundle\Entity\Conference $conference) {
        $em = $this->getDoctrine()->getEntityManager();
        return $this->createFormBuilder()
            ->add('user', 'choice', array('choices' => $em->getRepository('CfpUserBundle:User')->findAllExceptAdmins($conference)))
            ->getForm()
        ;
    }

    // Generate host dropdown without the current hosts for the conference
    protected function _getHostForm(\Cfp\ConferenceBundle\Entity\Conference $conference) {
        $em = $this->getDoctrine()->getEntityManager();
        return $this->createFormBuilder()
            ->add('user', 'choice', array('choices' => $em->getRepository('CfpUserBundle:User')->findAllExceptHosts($conference)))
            ->getForm()
        ;
    }


    // Gets information from the specified forms,
    protected function _postMutateUser($tag, $method, $action) {
        if ($this->getRequest()->getMethod() != 'POST') {
            throw new \Symfony\Component\Routing\Exception\MethodNotAllowedException("Must be posted");
        }

        // Sanity checks on the method & actions
        if (! in_array ($method, array("admin", "host"))) {
            throw new \InvalidArgumentException("Invalid method: '$method'");
        }
        if (! in_array ($action, array("add", "remove"))) {
            throw new \InvalidArgumentException("Invalid action: '$action'");
        }

        // Find and check conference
        $em = $this->getDoctrine()->getEntityManager();
        $conference = $em->getRepository('CfpConferenceBundle:Conference')->findOneByTag($tag);
        if (!$conference) {
            throw $this->createNotFoundException('Unable to find this conference.');
        }


        // Generate correct form
        if ($method == "admin") {
            $admin_form = $this->_getAdminForm($conference);
            $admin_form->bindRequest($this->getRequest());
            $data = $admin_form->getData();
        } else {
            $host_form = $this->_getHostForm($conference);
            $host_form->bindRequest($this->getRequest());
            $data = $host_form->getData();
        }

        return $this->_mutateUser($conference, $method, $action, $data['user']);
    }


    protected function _mutateUser($conference, $method, $action, $username)
    {
        // Find and check user
        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->getRepository('CfpUserBundle:User')->findOneByUsername($username);
        if (!$user) {
            throw $this->createNotFoundException('Unable to find the user.');
        }

        // Do not allow to remove yourself as an admin
        $currentUser = $this->get('security.context')->getToken()->getUser();
        if ($method == "admin" && $action == "remove" && $user == $currentUser) {
            throw new \DomainException("Cannot remove yourself as an admin");
        }

        // Such a bad way to generate the correct method to call.
        $method = $action . ucfirst(strtolower($method));

        // Call method and persist
        $conference->$method($user);
        $em->persist($conference);
        $em->flush();

        // Set flash banner
        if ($action == "add") {
            $this->get('session')->setFlash('notice', 'User has been added');
        } else {
            $this->get('session')->setFlash('notice', 'User has been removed');
        }

        // Redirect back to the list
        return $this->redirect($this->generateUrl('CfpConferenceBundle_conference_admin', array('tag' => $conference->getTag())));
    }

}
