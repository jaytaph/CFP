<?php

namespace Cfp\ConferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ConferenceType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('dt_start')
            ->add('dt_end')
            ->add('cfp_start')
            ->add('cfp_end')
            ->add('description')
            ->add('geo_long')
            ->add('geo_lat')
            ->add('tag')
        ;
    }

    public function getName()
    {
        return 'cfp_conferencebundle_conferencetype';
    }
}
