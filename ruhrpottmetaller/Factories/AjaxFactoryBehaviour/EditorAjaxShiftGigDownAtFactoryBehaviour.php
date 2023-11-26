<?php

namespace ruhrpottmetaller\Factories\AjaxFactoryBehaviour;

use mysqli;
use ruhrpottmetaller\Controller\Command\AbstractCommandController;
use ruhrpottmetaller\Controller\Command\EditorAjaxShiftGigDownAtCommandController;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;

class EditorAjaxShiftGigDownAtFactoryBehaviour
{
    private mysqli $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function getCommandController(
        array $input
    ): AbstractCommandController {
        return EditorAjaxShiftGigDownAtCommandController::new(
            SessionGigCommandModel::new(DatabaseBandQueryModel::new($this->connection)),
            RmInt::new($input['position']),
        );
    }
}
