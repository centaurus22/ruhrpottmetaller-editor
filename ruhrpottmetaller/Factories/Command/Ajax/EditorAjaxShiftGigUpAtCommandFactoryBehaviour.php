<?php

namespace ruhrpottmetaller\Factories\Command\Ajax;

use mysqli;
use ruhrpottmetaller\Controller\Command\AbstractCommandController;
use ruhrpottmetaller\Controller\Command\Ajax\EditorAjaxShiftGigUpAtCommandController;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;

class EditorAjaxShiftGigUpAtCommandFactoryBehaviour
{
    private mysqli $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function getCommandController(
        array $input
    ): AbstractCommandController {
        return EditorAjaxShiftGigUpAtCommandController::new(
            SessionGigCommandModel::new(DatabaseBandQueryModel::new($this->connection)),
            RmInt::new($input['position']),
        );
    }
}