<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;

class BaseDisplayController extends AbstractDisplayController
{
    protected function prepareThisController(): void
    {
        $this->view->set(
            'menu',
            RmArray::new()
                ->add(RmString::new('events'))
                ->add(RmString::new('bands'))
                ->add(RmString::new('venues'))
                ->add(RmString::new('cities'))
        );
    }
}
