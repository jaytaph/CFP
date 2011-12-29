<?php

namespace Cfp\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TalkType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('abstract')
            ->add('type', 'talktype')
            ->add('remark')
            ->add('slides_url')
            ->add('joindin_url')
            ->add('owners')
        ;
    }

    public function getName()
    {
        return 'cfp_userbundle_talktype';
    }
}
