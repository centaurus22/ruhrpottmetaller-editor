<?php

namespace ruhrpottmetaller\Factories\MainDisplayFactoryBehaviour;

use mysqli;
use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, Main\CityMainDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Factories\IGeneralDisplayFactoryBehaviour;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;
use ruhrpottmetaller\View\View;

class CityMainDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        mysqli $connection
    ): AbstractDisplayController {
        return new CityMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('city_main')
            ),
            DatabaseCityQueryModel::new($connection)
        );
    }
}
