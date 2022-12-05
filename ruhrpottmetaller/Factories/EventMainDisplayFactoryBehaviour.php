<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\AbstractDisplayController;
use ruhrpottmetaller\Controller\EventMainDisplayController;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\DatabaseConnectHelper;
use ruhrpottmetaller\Model\QueryEventDatabaseModel;
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
        $mainDisplayController = new EventMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('event_main')
            ),
            QueryEventDatabaseModel::new(
                DatabaseConnectHelper::new($pathToDatabaseConfig)->connect()->getConnection(),
            )
        );
        $mainDisplayController->setMonth(RmDate::new('2022-10'));
        return $mainDisplayController;
    }
}
