<?php

namespace Cfp\CfpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('biography')
            ->add('remarks', 'textarea');
    }

    public function getName()
    {
        return 'cfp_cfpbundle_registration';
    }
}
