<?php

namespace Cfp\ConferenceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ConferenceType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        // @TODO: It would be nice if we actually got a normal d/m/Y select with JQueryUI in it.
        $builder
            ->add('name')
            ->add('dt_start', 'jquery_date', array('format' => 'dd/MM/y'))
            ->add('dt_end', 'jquery_date', array('format' => 'dd/MM/y'))
            ->add('cfp_start', 'jquery_date', array('format' => 'dd/MM/y'))
            ->add('cfp_end', 'jquery_date', array('format' => 'dd/MM/y'))
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
