<?php

namespace ruhrpottmetaller\Factories\Display\Ajax;

use mysqli;
use ruhrpottmetaller\Controller\Display\AbstractDisplayController;
use ruhrpottmetaller\Controller\Display\Ajax\EditorAjaxInitialLineupDisplayController;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseGigQueryModel;
use ruhrpottmetaller\View\View;

class EditorAjaxInitialLineupDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        mysqli $connection,
        array $input
    ): AbstractDisplayController {
        return new EditorAjaxInitialLineupDisplayController(
            View::new(
                $templatePath,
                RmString::new('ajax/editor_lineup')
            ),
            DatabaseGigQueryModel::new($connection, DatabaseBandQueryModel::new($connection)),
            SessionGigCommandModel::new(DatabaseBandQueryModel::new($connection)),
            AbstractRmInt::new($input['event_id'])
        );
    }
}
