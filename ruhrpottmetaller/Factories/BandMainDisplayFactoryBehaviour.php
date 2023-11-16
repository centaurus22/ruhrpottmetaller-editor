<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, BandMainDisplayController};
use mysqli;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;
use ruhrpottmetaller\View\View;

class BandMainDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        mysqli $connection
    ): AbstractDisplayController {
        return new BandMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('band_main')
            ),
            DatabaseBandQueryModel::new($connection)
        );
    }
}
