<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\RmString;
use ruhrpottmetaller\Data\RmArray;

class BaseDisplayController extends AbstractDisplayController
{
    protected function prepareThisController(): void
    {
        $this->View->set(
            'menu',
            RmArray::new()
                ->add(RmString::new('events'))
                ->add(RmString::new('bands'))
                ->add(RmString::new('cities'))
                ->add(RmString::new('venues'))
        );
    }
}