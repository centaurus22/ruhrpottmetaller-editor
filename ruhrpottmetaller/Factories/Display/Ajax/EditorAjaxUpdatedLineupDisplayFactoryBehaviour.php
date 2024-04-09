<?php

namespace ruhrpottmetaller\Factories\Display\Ajax;

use mysqli;
use ruhrpottmetaller\Controller\Display\AbstractDisplayController;
use ruhrpottmetaller\Controller\Display\Ajax\EditorAjaxUpdatedLineupDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Query\SessionGigQueryModel;
use ruhrpottmetaller\View\View;

class EditorAjaxUpdatedLineupDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        mysqli $connection,
        array $input
    ): AbstractDisplayController {
        return new EditorAjaxUpdatedLineupDisplayController(
            View::new(
                $templatePath,
                RmString::new('ajax/editor_lineup')
            ),
            SessionGigQueryModel::new(),
        );
    }
}
