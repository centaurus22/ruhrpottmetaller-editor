<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\Display\{AbstractDisplayController, BandMainDisplayController};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\BandQueryModel;
use ruhrpottmetaller\View\View;

class BandMainDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    public function getDisplayController(
        RmString $templatePath,
        \mysqli $connection
    ): AbstractDisplayController {
        return new BandMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('band_main')
            ),
            BandQueryModel::new($connection)
        );
    }
}
