<?php

namespace ruhrpottmetaller\Controller\Command;

use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;

class EditorAjaxSetBandNameAtCommandController extends AbstractCommandController
{
    protected RmInt $position;
    protected RmString $bandName;

    public function __construct(
        SessionGigCommandModel $commandModel,
        RmInt $position,
        RmString $bandName
    ) {
        parent::__construct($commandModel);
        $this->position = $position;
        $this->bandName = $bandName;
    }

    public static function new(
        SessionGigCommandModel $commandModel,
        RmInt $position,
        RmString $bandName
    ): AbstractCommandController {
        return new static($commandModel, $position, $bandName);
    }

    public function execute(): void
    {
        $this->commandModel->setBandNameAt($this->position, $this->bandName);
    }
}
