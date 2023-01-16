<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Controller\AbstractCommandController;
use ruhrpottmetaller\Controller\GeneralCommandController;
use ruhrpottmetaller\Controller\NullCommandController;
use ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData;
use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\BandCommandModel;
use ruhrpottmetaller\Model\Connection;

class CommandFactory extends AbstractRmObject
{
    public function getCommandController(array $input): AbstractCommandController
    {
        $pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
        $databaseConnection = Connection::new($pathToDatabaseConfig)
            ->connect()
            ->getConnection();
        if (isset($input['save']) and $input['save'] == 'band') {
            return GeneralCommandController::new(
                BandCommandModel::new($databaseConnection),
                $this->getDataObject($input)
            );
        }

        return NullCommandController::new(null, null);
    }

    private function getDataObject(array $input): AbstractHighLevelData
    {
        return Band::new()
            ->setId(RmInt::new($input['id']))
            ->setName(RmString::new($input['name']))
            ->setIsVisible(RmBool::new($input['is_visible']));
    }
}
