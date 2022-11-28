<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\AbstractDisplayController;
use ruhrpottmetaller\Controller\BandMainDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\DatabaseConnectHelper;
use ruhrpottmetaller\Model\QueryBandDatabaseModel;
use ruhrpottmetaller\View\View;

class BandMainDisplayFactoryBehaviour implements IMainDisplayFactoryBehaviour
{
    /**
     * @throws \Exception
     */
    public function getDisplayController(
        RmString $templatePath,
        RmString $pathToDatabaseConfig
    ): AbstractDisplayController {
        $pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
        return new BandMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('band_main')
            ),
            QueryBandDatabaseModel::new(
                DatabaseConnectHelper::new($pathToDatabaseConfig)->connect()->getConnection(),
                RmArray::new()
            )
        );
    }
}
