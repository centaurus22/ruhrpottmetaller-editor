<?php

namespace ruhrpottmetaller\Factories\NavSecondaryDisplayFactoryBehaviour;

use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, CharNavSecondaryDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Factories\IGeneralDisplayFactoryBehaviour;
use ruhrpottmetaller\View\View;

class CityNavSecondaryDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        \mysqli $connection
    ): AbstractDisplayController {
        return new CharNavSecondaryDisplayController(
            View::new(
                $templatePath,
                RmString::new('city_nav_secondary')
            ),
        );
    }
}
