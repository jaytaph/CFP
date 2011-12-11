<?php

namespace Cfp\CfpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CfpTalkType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('remarks')
            ->add('dt_created')
            ->add('talk')
        ;
    }

    public function getName()
    {
        return 'cfp_cfpbundle_cfptalktype';
    }
}
