<?php

namespace ruhrpottmetaller\Factories\AjaxDisplayFactoryBehaviour;

use mysqli;
use ruhrpottmetaller\Controller\Display\AbstractDisplayController;
use ruhrpottmetaller\Controller\Display\Ajax\EditorAjaxLineupDisplayController;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseGigQueryModel;
use ruhrpottmetaller\View\View;

class EditorAjaxLineupDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        mysqli $connection,
        array $input
    ): AbstractDisplayController {
        return new EditorAjaxLineupDisplayController(
            View::new(
                $templatePath,
                RmString::new('ajax/editor_lineup')
            ),
            DatabaseGigQueryModel::new($connection, DatabaseBandQueryModel::new($connection)),
            AbstractRmInt::new($input['event_id'])
        );
    }
}
