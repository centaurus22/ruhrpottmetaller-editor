<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\AbstractDisplayController;
use ruhrpottmetaller\Controller\EventHeadDisplayController;
use ruhrpottmetaller\Controller\EventMainDisplayController;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\DatabaseConnectHelper;
use ruhrpottmetaller\Model\QueryEventDatabaseModel;
use ruhrpottmetaller\View\View;

class EventFactoryBehaviour implements IFactoryBehaviour
{
    public function getHeadDisplayController(RmString $templatePath): AbstractDisplayController
    {
        return new EventHeadDisplayController(
            View::new(
                $templatePath,
                RmString::new('event_head')
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
        $mainDisplayController = new EventMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('event_main')
            ),
            QueryEventDatabaseModel::new(
                DatabaseConnectHelper::new($pathToDatabaseConfig)->connect()->getConnection(),
                RmArray::new()
            )
        );
        $mainDisplayController->setMonth(RmDate::new('2022-10'));
        return $mainDisplayController;
    }
}
