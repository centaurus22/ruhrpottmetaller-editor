<?php

namespace ruhrpottmetaller\Controller\Command\Ordinary;

class GeneralCommandController extends AbstractGeneralCommandController
{
    public function execute(): void
    {
        $this->commandModel->replaceData($this->highLevelData);
    }
}
