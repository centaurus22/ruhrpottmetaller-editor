<?php

namespace ruhrpottmetaller\Factories\AjaxFactoryBehaviour;

use mysqli;
use ruhrpottmetaller\Controller\Command\AbstractCommandController;
use ruhrpottmetaller\Controller\Command\EditorAjaxChangeGigAtCommandController;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;

class EditorAjaxChangeGigAtFactoryBehaviour
{
    private mysqli $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function getCommandController(
        array $input
    ): AbstractCommandController {
        return EditorAjaxChangeGigAtCommandController::new(
            $this->connection,
            RmInt::new($input['position']),
            RmInt::new($input['band_id'])
        );
    }
}
