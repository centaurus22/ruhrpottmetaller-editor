<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\AbstractDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

interface IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        \mysqli $connection
    ): AbstractDisplayController;
}
