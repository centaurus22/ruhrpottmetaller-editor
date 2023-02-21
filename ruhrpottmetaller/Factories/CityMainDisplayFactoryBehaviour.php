<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, CityMainDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\CityQueryModel;
use ruhrpottmetaller\View\View;

class CityMainDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        \mysqli $connection
    ): AbstractDisplayController {
        return new CityMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('city_main')
            ),
            CityQueryModel::new($connection)
        );
    }
}
