<?php

namespace ruhrpottmetaller\Controller\Command\Ordinary;

class GeneralSaveCommandController extends AbstractOrdinaryCommandController
{
    public function execute(): void
    {
        $this->commandModel->replaceData($this->data);
    }
}
