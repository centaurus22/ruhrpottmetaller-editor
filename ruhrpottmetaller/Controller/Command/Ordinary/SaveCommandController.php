<?php

namespace ruhrpottmetaller\Controller\Command\Ordinary;

class SaveCommandController extends AbstractGeneralCommandController
{
    public function execute(): void
    {
        $this->commandModel->replaceData($this->highLevelData);
    }
}
