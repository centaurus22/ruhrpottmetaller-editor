<?php

namespace ruhrpottmetaller\Controller\Command;

use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;

class EditorAjaxSetAdditionalInformationAtCommandController extends AbstractCommandController
{
    protected RmInt $position;
    protected RmString $additionalInformation;

    public function __construct(
        SessionGigCommandModel $commandModel,
        RmInt $position,
        RmString $additionalInformation
    ) {
        parent::__construct($commandModel);
        $this->position = $position;
        $this->additionalInformation = $additionalInformation;
    }

    public static function new(
        SessionGigCommandModel $commandModel,
        RmInt $position,
        RmString $additionalInformation
    ): AbstractCommandController {
        return new static($commandModel, $position, $additionalInformation);
    }

    public function execute(): void
    {
        $this->commandModel->setAdditionalInfornationAt(
            $this->position,
            $this->additionalInformation
        );
    }
}
