<?php

namespace ruhrpottmetaller\Controller\Command\Ajax;

use ruhrpottmetaller\Controller\Command\AbstractCommandController;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;

class EditorAjaxShiftGigUpAtCommandController extends AbstractCommandController
{
    protected RmInt $position;

    public function __construct(
        SessionGigCommandModel $commandModel,
        RmInt $position,
    ) {
        parent::__construct($commandModel);
        $this->position = $position;
    }

    public static function new(
        SessionGigCommandModel $commandModel,
        RmInt $position,
    ): AbstractCommandController {
        return new static($commandModel, $position);
    }

    public function execute(): void
    {
        $this->commandModel->shiftGigUpAt($this->position);
    }
}
