<?php

namespace ruhrpottmetaller\Controller\Command;

use ruhrpottmetaller\Model\Command\DatabaseCommandModel;

abstract class AbstractCommandController
{
    protected ?DatabaseCommandModel $commandModel;

    public function __construct($commandModel)
    {
        $this->commandModel = $commandModel;
    }


}
