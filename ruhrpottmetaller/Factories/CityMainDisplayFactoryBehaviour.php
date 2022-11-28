<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\AbstractDisplayController;
use ruhrpottmetaller\Controller\CityMainDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\DatabaseConnectHelper;
use ruhrpottmetaller\Model\QueryCityDatabaseModel;
use ruhrpottmetaller\View\View;

class CityMainDisplayFactoryBehaviour implements IMainDisplayFactoryBehaviour
{
    /**
     * @throws \Exception
     */
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
                DatabaseConnectHelper::new($pathToDatabaseConfig)->connect()->getConnection(),
                RmArray::new()
            )
        );
    }
}
