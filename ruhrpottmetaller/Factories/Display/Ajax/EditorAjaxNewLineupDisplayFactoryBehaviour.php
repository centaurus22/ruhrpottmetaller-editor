<?php

namespace ruhrpottmetaller\Factories\Display\Ajax;

use mysqli;
use ruhrpottmetaller\Controller\Display\Ajax\EditorAjaxNewLineupDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;
use ruhrpottmetaller\View\View;

class EditorAjaxNewLineupDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        mysqli $connection,
        array $input
    ): EditorAjaxNewLineupDisplayController {
        return new EditorAjaxNewLineupDisplayController(
            View::new(
                $templatePath,
                RmString::new('ajax/editor_lineup')
            ),
            SessionGigCommandModel::new(DatabaseBandQueryModel::new($connection)),
        );
    }
}
