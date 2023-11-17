<?php

namespace ruhrpottmetaller\Factories\NavSecondaryDisplayFactoryBehaviour;

use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, CharNavSecondaryDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Factories\IGeneralDisplayFactoryBehaviour;
use ruhrpottmetaller\View\View;

class BandNavSecondaryDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        \mysqli $connection
    ): AbstractDisplayController {
        return new CharNavSecondaryDisplayController(
            View::new(
                $templatePath,
                RmString::new('band_nav_secondary')
            ),
        );
    }
}
