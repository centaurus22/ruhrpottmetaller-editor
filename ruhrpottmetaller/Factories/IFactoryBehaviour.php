<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\AbstractDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

interface IFactoryBehaviour
{
    public function getHeadDisplayController(RmString $templatePath): AbstractDisplayController;
    public function getMainDisplayController(
        RmString $templatePath,
        RmString $pathToDatabaseConfig
    ): AbstractDisplayController;
}
