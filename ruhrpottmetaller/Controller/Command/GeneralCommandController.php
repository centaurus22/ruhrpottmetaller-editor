<?php

namespace ruhrpottmetaller\Controller\Command;

class GeneralCommandController extends AbstractCommandController
{
    public function execute(): void
    {
        $this->commandModel->replaceData($this->highLevelData);
    }
}
