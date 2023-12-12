<?php

namespace ruhrpottmetaller\Factories\Command\Ordinary;

use ruhrpottmetaller\Controller\Command\AbstractCommandController;
use ruhrpottmetaller\Controller\Command\Ordinary\NullCommandController;

class NullCommandFactoryBehaviour
{
    public function getCommandController(array $input): AbstractCommandController
    {
        return NullCommandController::new(null, null);
    }
}
