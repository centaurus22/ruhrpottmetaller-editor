<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\{AbstractDisplayController, VenueMainDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{Connection, CityQueryModel, VenueQueryModel};
use ruhrpottmetaller\View\View;

class VenueMainDisplayFactoryBehaviour implements IMainDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        RmString $pathToDatabaseConfig
    ): AbstractDisplayController {
        $pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
        $databaseConnection = Connection::new($pathToDatabaseConfig)
            ->connect()
            ->getConnection();
        return new VenueMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('venue_main')
            ),
            VenueQueryModel::new(
                $databaseConnection,
                CityQueryModel::new($databaseConnection)
            )
        );
    }
}
