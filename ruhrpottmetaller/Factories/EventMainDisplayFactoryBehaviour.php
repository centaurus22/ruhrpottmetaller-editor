<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\{AbstractDisplayController, EventMainDisplayController};
use ruhrpottmetaller\Model\{
    Connection,
    QueryCityModel,
    QueryEventModel,
    QueryVenueModel
};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\View\View;

class EventMainDisplayFactoryBehaviour implements IMainDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        RmString $pathToDatabaseConfig
    ): AbstractDisplayController {
        $pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
        $databaseConnection = Connection::new($pathToDatabaseConfig)
            ->connect()
            ->getConnection();
        return new EventMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('event_main')
            ),
            QueryEventModel::new(
                $databaseConnection,
                QueryVenueModel::new(
                    $databaseConnection,
                    QueryCityModel::new($databaseConnection)
                )
            )
        );
    }
}
