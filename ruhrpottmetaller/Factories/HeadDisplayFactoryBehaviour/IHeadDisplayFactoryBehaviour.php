<?php

namespace ruhrpottmetaller\Factories\HeadDisplayFactoryBehaviour;

use ruhrpottmetaller\Controller\Display\AbstractDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

interface IHeadDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath
    ): AbstractDisplayController;
}
