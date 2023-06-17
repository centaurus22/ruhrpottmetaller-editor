<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, EventMainDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\DatabaseBandQueryModel;
use ruhrpottmetaller\Model\DatabaseCityQueryModel;
use ruhrpottmetaller\Model\DatabaseEventQueryModel;
use ruhrpottmetaller\Model\DatabaseGigQueryModel;
use ruhrpottmetaller\Model\DatabaseVenueQueryModel;
use ruhrpottmetaller\View\View;

class EventMainDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        \mysqli $connection
    ): AbstractDisplayController {
        return new EventMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('event_main')
            ),
            DatabaseEventQueryModel::new(
                $connection,
                DatabaseGigQueryModel::new(
                    $connection,
                    DatabaseBandQueryModel::new($connection)
                ),
                DatabaseVenueQueryModel::new(
                    $connection,
                    DatabaseCityQueryModel::new($connection)
                )
            )
        );
    }
}
