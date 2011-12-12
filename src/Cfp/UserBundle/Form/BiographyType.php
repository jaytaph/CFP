<?php

namespace Cfp\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class BiographyType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('description');
        $builder->add('biography', 'textarea');

        $builder->add('picture', 'file');

        $builder->add('joindin_url', 'url');
        $builder->add('slideshare_url', 'url');
        $builder->add('blog_url', 'url');
        $builder->add('homepage_url', 'url');
    }

    public function getName()
    {
        return 'biography';
    }
}
