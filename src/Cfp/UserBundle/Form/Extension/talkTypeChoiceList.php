<?php

namespace Cfp\UserBundle\Form\Extension;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Locale\Locale;

class talkTypeChoiceList extends AbstractType
{
    // @TODO: this should be more custom (maybe fetch from database or something?)
    protected $talkTypes = array("talk", "workshop", "keynote", "discussion", "other");

    public function getDefaultOptions(array $options)
    {
        return array(
            'choices' => $this->talkTypes
        );
    }

    public function getParent(array $options)
    {
        return 'choice';
    }

    public function getName()
    {
        return 'talktype';
    }
}
