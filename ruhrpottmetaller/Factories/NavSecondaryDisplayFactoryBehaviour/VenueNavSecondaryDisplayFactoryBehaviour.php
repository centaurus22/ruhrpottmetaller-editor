<?php

namespace ruhrpottmetaller\Factories\NavSecondaryDisplayFactoryBehaviour;

use mysqli;
use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, NavSecondary\CityNavSecondaryDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Factories\IGeneralDisplayFactoryBehaviour;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;
use ruhrpottmetaller\View\View;

class VenueNavSecondaryDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        mysqli $connection
    ): AbstractDisplayController {
        return new CityNavSecondaryDisplayController(
            View::new(
                $templatePath,
                RmString::new('venue_nav_secondary')
            ),
            DatabaseCityQueryModel::new($connection)
        );
    }
}
