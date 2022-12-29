<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\{AbstractDisplayController, BandMainDisplayController};
use ruhrpottmetaller\Model\{Connection, QueryBandModel};
use ruhrpottmetaller\View\View;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class BandMainDisplayFactoryBehaviour implements IMainDisplayFactoryBehaviour
{
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
            QueryBandModel::new(
                Connection::new($pathToDatabaseConfig)->connect()->getConnection(),
            )
        );
    }
}
