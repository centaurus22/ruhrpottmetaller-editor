<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\Display\{AbstractDisplayController,
    EditorAjaxCityVenueDisplayController};
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{DatabaseCityQueryModel, DatabaseVenueQueryModel};
use ruhrpottmetaller\View\View;

class EditorAjaxCityVenueDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        \mysqli $connection,
        array $input
    ): AbstractDisplayController {
        $controller = new EditorAjaxCityVenueDisplayController(
            View::new(
                $templatePath,
                RmString::new('editor_ajax_city_venue')
            ),
            DatabaseCityQueryModel::new($connection),
            DatabaseVenueQueryModel::new($connection, DatabaseCityQueryModel::new($connection))
        );

        $controller->setVenueId(RmInt::new($input['venue_id'] ?? null));
        $controller->setCityId(RmInt::new($input['city_id'] ?? null));
        return $controller;
    }
}