<?php

namespace ruhrpottmetaller\Controller;

class GeneralCommandController extends AbstractCommandController
{
    public function execute(): void
    {
        $this->commandModel->replaceData($this->highLevelData);
    }
}
