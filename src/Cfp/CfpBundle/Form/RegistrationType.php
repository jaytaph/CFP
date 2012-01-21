<?php

namespace Cfp\CfpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RegistrationType extends AbstractType
{
    protected $_user;

    function __construct(\Cfp\UserBundle\Entity\User $user)
    {
        $this->_user = $user;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $biographies = $this->_user->getBiographies()->toArray();
        $builder
            ->add('biography', 'choice', array('choices' => $biographies))
            ->add('remarks', 'textarea');
    }

    public function getName()
    {
        return 'cfp_cfpbundle_registration';
    }
}
