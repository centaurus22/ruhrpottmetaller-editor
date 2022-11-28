<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\AbstractDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

interface IMainDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        RmString $pathToDatabaseConfig
    ): AbstractDisplayController;
}
