<?php

namespace ruhrpottmetaller\Factories\Command\Ordinary;

use mysqli;
use ruhrpottmetaller\Controller\Command\AbstractCommandController;
use ruhrpottmetaller\Controller\Command\Ordinary\SetCanceledCommandController;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Model\Command\DatabaseEventCommandModel;

class SetCanceledCommandFactoryBehaviour
{
    private mysqli $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function getCommandController(array $input): AbstractCommandController
    {
        return SetCanceledCommandController::new(
            new DatabaseEventCommandModel($this->connection),
            RmInt::new($input['id'])
        );
    }
}
