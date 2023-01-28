<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\{AbstractDisplayController, EventMainDisplayController};
use ruhrpottmetaller\Model\{BandQueryModel, CityQueryModel, EventQueryModel, GigQueryModel, VenueQueryModel};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\View\View;

class EventMainDisplayFactoryBehaviour implements IMainDisplayFactoryBehaviour
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
