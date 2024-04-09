<?php

namespace ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;

class CharNavSecondaryDisplayController extends AbstractDataMainDisplayController
{
    protected function prepareThisController(): void
    {
        $this->transferGetParametersToView();
        $alphabetArray = RmArray::new()
            ->add(RmString::new('%'));

        foreach (range('A', 'Z') as $char) {
            $alphabetArray->add(RmString::new($char));
        }

        $this->view->set(
            'firstChars',
            $alphabetArray
        );
    }
}
