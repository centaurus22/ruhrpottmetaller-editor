<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Controller\AbstractDisplayController;
use ruhrpottmetaller\Controller\BaseDisplayController;
use ruhrpottmetaller\Controller\EventHeadDisplayController;
use ruhrpottmetaller\Controller\EventMainDisplayController;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\DatabaseConnectHelper;
use ruhrpottmetaller\Model\QueryEventDatabaseModel;
use ruhrpottmetaller\View\View;

class DisplayFactory extends AbstractRmObject
{
    private RmString $templatePath;

    public function __construct()
    {
        $this->templatePath = RmString::new('../templates/');
    }

    /**
     * @throws \Exception
     */
    public function getDisplayController(array $input): AbstractDisplayController
    {
        $eventHeadDisplayController = new EventHeadDisplayController(
            View::new(
                $this->templatePath,
                RmString::new('event_head')
            )
        );

        $pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
        $eventMainDisplayController = new EventMainDisplayController(
            View::new(
                $this->templatePath,
                RmString::new('event_main')
            ),
            QueryEventDatabaseModel::new(
                DatabaseConnectHelper::new($pathToDatabaseConfig)->connect()->getConnection(),
                RmArray::new()
            )
        );
        $eventMainDisplayController->setMonth(RmDate::new('2022-10'));
        $baseDisplayController =  new BaseDisplayController(
            View::new(
                $this->templatePath,
                RmString::new('ruhrpottmetaller-editor')
            )
        );
        return $baseDisplayController->addSubController(
            'eventHeadDisplayController',
            $eventHeadDisplayController
        )->addSubController(
            'eventMainDisplayController',
            $eventMainDisplayController
        );
    }
}
