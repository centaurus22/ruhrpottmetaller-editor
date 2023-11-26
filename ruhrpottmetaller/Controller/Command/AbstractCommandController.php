<?php

namespace ruhrpottmetaller\Controller\Command;

abstract class AbstractCommandController
{
    protected $commandModel;

    public function __construct($commandModel)
    {
        $this->commandModel = $commandModel;
    }


}
