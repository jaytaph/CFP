<?php

namespace Cfp\CfpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SubmissionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('talk')
            ->add('remarks')
        ;
    }

    public function getName()
    {
        return 'cfp_cfpbundle_submission';
    }
}
