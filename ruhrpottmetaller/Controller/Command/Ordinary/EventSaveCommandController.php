<?php

namespace ruhrpottmetaller\Controller\Command\Ordinary;

class EventSaveCommandController extends AbstractOrdinaryCommandController
{
    public function execute(): void
    {
        if ($this->data->getId()->get() === 0) {
            $this->commandModel->addEvent($this->data);
        } else {
            $this->commandModel->replaceData($this->data);
        }
    }
}
