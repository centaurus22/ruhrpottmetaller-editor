<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\{AbstractDisplayController, VenueMainDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{CityQueryModel, VenueQueryModel};
use ruhrpottmetaller\View\View;

class VenueMainDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        \mysqli $connection
    ): AbstractDisplayController {
        return new VenueMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('venue_main')
            ),
            VenueQueryModel::new(
                $connection,
                CityQueryModel::new($connection)
            )
        );
    }
}
