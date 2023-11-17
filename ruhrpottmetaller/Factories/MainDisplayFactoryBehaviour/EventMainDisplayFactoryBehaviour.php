<?php

namespace ruhrpottmetaller\Factories\MainDisplayFactoryBehaviour;

use mysqli;
use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, EventMainDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Factories\IGeneralDisplayFactoryBehaviour;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseEventQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseGigQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel;
use ruhrpottmetaller\View\View;

class EventMainDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        mysqli $connection
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
