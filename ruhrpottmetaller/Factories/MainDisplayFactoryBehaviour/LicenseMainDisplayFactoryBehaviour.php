<?php

namespace ruhrpottmetaller\Factories\MainDisplayFactoryBehaviour;

use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, Main\LicenseMainDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Factories\IGeneralDisplayFactoryBehaviour;
use ruhrpottmetaller\View\View;

class LicenseMainDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        \mysqli $connection
    ): AbstractDisplayController {
        return new LicenseMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('license_main')
            )
        );
    }
}
