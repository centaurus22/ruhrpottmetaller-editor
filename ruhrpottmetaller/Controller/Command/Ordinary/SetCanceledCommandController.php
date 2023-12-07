<?php

namespace ruhrpottmetaller\Controller\Command\Ordinary;

class SetCanceledCommandController extends AbstractOrdinaryCommandController
{
    public function execute(): void
    {
        $this->commandModel->setCanceled($this->data);
    }
}
