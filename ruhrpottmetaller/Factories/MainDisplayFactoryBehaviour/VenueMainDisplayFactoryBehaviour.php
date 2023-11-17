<?php

namespace ruhrpottmetaller\Factories\MainDisplayFactoryBehaviour;

use mysqli;
use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, VenueMainDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Factories\IGeneralDisplayFactoryBehaviour;
use ruhrpottmetaller\Model\{Query\DatabaseCityQueryModel, Query\DatabaseVenueQueryModel};
use ruhrpottmetaller\View\View;

class VenueMainDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        mysqli $connection
    ): AbstractDisplayController {
        return new VenueMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('venue_main')
            ),
            DatabaseVenueQueryModel::new(
                $connection,
                DatabaseCityQueryModel::new($connection)
            )
        );
    }
}
