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
    /**
     * @throws \Exception
     */
    public function getDisplayController(
        RmString $templatePath,
        RmString $pathToDatabaseConfig
    ): AbstractDisplayController {
        $pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
        $databaseConnection = DatabaseConnection::new($pathToDatabaseConfig)
            ->connect()
            ->getConnection();
        $mainDisplayController = new EventMainDisplayController(
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
        $mainDisplayController->setMonth(RmDate::new('2022-10'));
        return $mainDisplayController;
    }
}
