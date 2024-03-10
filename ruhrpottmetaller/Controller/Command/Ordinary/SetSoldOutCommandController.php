<?php

namespace ruhrpottmetaller\Controller\Command\Ordinary;

class SetSoldOutCommandController extends AbstractOrdinaryCommandController
{
    public function execute(): void
    {
        $this->commandModel->setSoldOut($this->data);
    }
}
