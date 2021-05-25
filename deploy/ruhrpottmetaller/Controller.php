<?php

namespace ruhrpottmetaller;

use ruhrpottmetaller\Commands\InterpreterCommandFactory;

class Controller
{
    private InterpreterCommandFactory $interpreterCommandFactory;

    public function __construct(
        InterpreterCommandFactory $interpreterCommandFactory
    ) {
        $this->interpreterCommandFactory = $interpreterCommandFactory;
    }

    public function printOutput(): void
    {
        $commandStorage = $this->interpreterCommandFactory->factoryMethod();
        while (!$commandStorage->isDone()) {
            $commandStorage->getCurrentItem()->execute();
            $commandStorage->setPointerToNextItem();
        }
    }
}
