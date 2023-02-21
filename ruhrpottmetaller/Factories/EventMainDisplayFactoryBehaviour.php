<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, EventMainDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{BandQueryModel, CityQueryModel, EventQueryModel, GigQueryModel, VenueQueryModel};
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
            EventQueryModel::new(
                $connection,
                GigQueryModel::new(
                    $connection,
                    BandQueryModel::new($connection)
                ),
                VenueQueryModel::new(
                    $connection,
                    CityQueryModel::new($connection)
                )
            )
        );
    }
}
