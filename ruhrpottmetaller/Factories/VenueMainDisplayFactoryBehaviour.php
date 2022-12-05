<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\AbstractDisplayController;
use ruhrpottmetaller\Controller\VenueMainDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\DatabaseConnectHelper;
use ruhrpottmetaller\Model\QueryCityDatabaseModel;
use ruhrpottmetaller\Model\QueryVenueDatabaseModel;
use ruhrpottmetaller\View\View;

class VenueMainDisplayFactoryBehaviour implements IMainDisplayFactoryBehaviour
{
    private \mysqli $databaseConnection;

    /**
     * @throws \Exception
     */
    public function getDisplayController(
        RmString $templatePath,
        RmString $pathToDatabaseConfig
    ): AbstractDisplayController {
        $pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
        $this->databaseConnection = DatabaseConnectHelper::new($pathToDatabaseConfig)->connect()->getConnection();
        return new VenueMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('venue_main')
            ),
            QueryVenueDatabaseModel::new(
                $this->databaseConnection,
                QueryCityDatabaseModel::new($this->databaseConnection)
            )
        );
    }
}
