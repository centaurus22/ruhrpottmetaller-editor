<?php

namespace ruhrpottmetaller\Factories\NavSecondaryDisplayFactoryBehaviour;

use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, NavSecondary\CharNavSecondaryDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Factories\IGeneralDisplayFactoryBehaviour;
use ruhrpottmetaller\View\View;

class EventNavSecondaryDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        \mysqli $connection
    ): AbstractDisplayController {
        return new CharNavSecondaryDisplayController(
            View::new(
                $templatePath,
                RmString::new('event_nav_secondary')
            ),
        );
    }
}
