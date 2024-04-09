<?php

namespace ruhrpottmetaller\Controller\Command\Ordinary;

class SaveCommandController extends AbstractOrdinaryCommandController
{
    public function execute(): void
    {
        $this->commandModel->replaceData($this->data);
    }
}
