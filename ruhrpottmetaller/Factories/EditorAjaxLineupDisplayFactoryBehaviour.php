<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\Display\AbstractDisplayController;
use ruhrpottmetaller\Controller\Display\EditorAjaxLineupDisplayController;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\DatabaseBandQueryModel;
use ruhrpottmetaller\Model\DatabaseGigQueryModel;
use ruhrpottmetaller\View\View;

class EditorAjaxLineupDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        \mysqli $connection,
        array $input
    ): AbstractDisplayController {
        return new EditorAjaxLineupDisplayController(
            View::new(
                $templatePath,
                RmString::new('editor_ajax_lineup')
            ),
            DatabaseGigQueryModel::new($connection, DatabaseBandQueryModel::new($connection)),
            AbstractRmInt::new($input['event_id'])
        );
    }
}