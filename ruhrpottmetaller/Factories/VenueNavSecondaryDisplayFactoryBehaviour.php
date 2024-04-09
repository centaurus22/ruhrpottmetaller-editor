<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\{AbstractDisplayController,
    CharNavSecondaryDisplayController,
    CityNavSecondaryDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\CityQueryModel;
use ruhrpottmetaller\View\View;

class VenueNavSecondaryDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        \mysqli $connection
    ): AbstractDisplayController {
        return new CityNavSecondaryDisplayController(
            View::new(
                $templatePath,
                RmString::new('venue_nav_secondary')
            ),
            CityQueryModel::new($connection)
        );
    }
}
