<?php

namespace ruhrpottmetaller\Factories\AjaxFactoryBehaviour;

use mysqli;
use ruhrpottmetaller\Controller\Command\AbstractCommandController;
use ruhrpottmetaller\Controller\Command\EditorAjaxSetAdditionalInformationAtCommandController;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;

class EditorAjaxSetAdditionalInformationAtFactoryBehaviour
{
    private mysqli $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function getCommandController(
        array $input
    ): AbstractCommandController {
        return EditorAjaxSetAdditionalInformationAtCommandController::new(
            SessionGigCommandModel::new(DatabaseBandQueryModel::new($this->connection)),
            RmInt::new($input['position']),
            RmString::new($input['additional_information'])
        );
    }
}
