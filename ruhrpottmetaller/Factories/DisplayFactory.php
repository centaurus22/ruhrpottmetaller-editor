<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Controller\AbstractDisplayController;
use ruhrpottmetaller\Controller\BaseDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\View\View;

class DisplayFactory extends AbstractRmObject
{
    private RmString $templatePath;

    public function __construct()
    {
        $this->templatePath = RmString::new('./templates/');
    }

    public function getDisplayController(array $input): AbstractDisplayController
    {
        return new BaseDisplayController(
            View::new(
                $this->templatePath,
                RmString::new('ruhrpottmetaller-editor')
            )
        );
    }
}