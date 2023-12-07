<?php

namespace ruhrpottmetaller\Controller\Command\Ordinary;

class DeleteCommandController extends AbstractOrdinaryCommandController
{
    public function execute(): void
    {
        $this->commandModel->delete($this->data);
    }
}
