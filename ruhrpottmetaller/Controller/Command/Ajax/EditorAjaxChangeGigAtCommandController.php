<?php

namespace ruhrpottmetaller\Controller\Command\Ajax;

use ruhrpottmetaller\Controller\Command\AbstractCommandController;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;

class EditorAjaxChangeGigAtCommandController extends AbstractCommandController
{
    protected RmInt $position;
    protected RmInt $bandId;

    public function __construct(
        SessionGigCommandModel $commandModel,
        RmInt $position,
        RmInt $bandId
    ) {
        parent::__construct($commandModel);
        $this->position = $position;
        $this->bandId = $bandId;
    }

    public static function new(
        SessionGigCommandModel $commandModel,
        RmInt $position,
        RmInt $bandId
    ): AbstractCommandController {
        return new static($commandModel, $position, $bandId);
    }

    public function execute(): void
    {
        $this->commandModel->changeGigAt($this->position, $this->bandId);
    }
}
