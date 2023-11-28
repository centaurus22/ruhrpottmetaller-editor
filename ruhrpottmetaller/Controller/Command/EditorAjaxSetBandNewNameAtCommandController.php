<?php

namespace ruhrpottmetaller\Controller\Command;

use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;

class EditorAjaxSetBandNewNameAtCommandController extends AbstractCommandController
{
    protected RmInt $position;
    protected RmString $bandNewName;

    public function __construct(
        SessionGigCommandModel $commandModel,
        RmInt $position,
        RmString $bandNewName
    ) {
        parent::__construct($commandModel);
        $this->position = $position;
        $this->bandNewName = $bandNewName;
    }

    public static function new(
        SessionGigCommandModel $commandModel,
        RmInt $position,
        RmString $bandNewName
    ): AbstractCommandController {
        return new static($commandModel, $position, $bandNewName);
    }

    public function execute(): void
    {
        $this->commandModel->setBandNewName($this->position, $this->bandNewName);
    }
}
