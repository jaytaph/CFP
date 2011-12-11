<?php

namespace Cfp\ConferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CfpType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('remarks', 'textarea')
            ->add('talk')
            ->add('conference');
    }

    public function getName()
    {
        return 'cfp_conferencebundle_cfptype';
    }
}
