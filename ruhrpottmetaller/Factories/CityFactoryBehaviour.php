<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\AbstractDisplayController;
use ruhrpottmetaller\Controller\CityMainDisplayController;
use ruhrpottmetaller\Controller\EventHeadDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\DatabaseConnectHelper;
use ruhrpottmetaller\Model\QueryCityDatabaseModel;
use ruhrpottmetaller\View\View;

class CityFactoryBehaviour implements IFactoryBehaviour
{
    public function getHeadDisplayController(RmString $templatePath): AbstractDisplayController
    {
        return new EventHeadDisplayController(
            View::new(
                $templatePath,
                RmString::new('city_head')
            )
        );
    }

    /**
     * @throws \Exception
     */
    public function getMainDisplayController(
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
