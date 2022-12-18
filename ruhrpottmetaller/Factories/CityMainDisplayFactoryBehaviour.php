<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\{AbstractDisplayController, CityMainDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{DatabaseConnection, QueryCityDatabaseModel};
use ruhrpottmetaller\View\View;

class CityMainDisplayFactoryBehaviour implements IMainDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        RmString $pathToDatabaseConfig
    ): AbstractDisplayController {
        $pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
        return new CityMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('city_main')
            ),
            QueryCityDatabaseModel::new(
                DatabaseConnection::new($pathToDatabaseConfig)->connect()->getConnection(),
            )
        );
    }
}
