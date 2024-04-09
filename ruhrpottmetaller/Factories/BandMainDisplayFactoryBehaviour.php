<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\{AbstractDisplayController, BandMainDisplayController};
use ruhrpottmetaller\Model\BandQueryModel;
use ruhrpottmetaller\View\View;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

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
