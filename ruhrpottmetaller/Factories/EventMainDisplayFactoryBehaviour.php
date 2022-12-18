<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\{AbstractDisplayController, EventMainDisplayController};
use ruhrpottmetaller\Model\{
    DatabaseConnection,
    QueryCityDatabaseModel,
    QueryEventDatabaseModel,
    QueryVenueDatabaseModel
};
use ruhrpottmetaller\Data\LowLevel\{Date\RmDate, String\RmString};
use ruhrpottmetaller\View\View;

class EventMainDisplayFactoryBehaviour implements IMainDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        RmString $pathToDatabaseConfig
    ): AbstractDisplayController {
        $pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
        $databaseConnection = DatabaseConnection::new($pathToDatabaseConfig)
            ->connect()
            ->getConnection();
        return new EventMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('event_main')
            ),
            QueryEventDatabaseModel::new(
                $databaseConnection,
                QueryVenueDatabaseModel::new(
                    $databaseConnection,
                    QueryCityDatabaseModel::new($databaseConnection)
                )
            )
        );
    }
}
