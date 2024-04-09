<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Factories\Command\Ordinary\GeneralCommandFactoryBehaviour;
use ruhrpottmetaller\Factories\Command\Ordinary\NullCommandFactoryBehaviour;

class CommandFactory extends AbstractFactory
{
    private object $factoryBehaviour;

    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function setFactoryBehaviour(array $input): CommandFactory
    {
        if (isset($input['save'])) {
            $this->factoryBehaviour = new GeneralCommandFactoryBehaviour($this->connection);
        } else {
            $this->factoryBehaviour =  new NullCommandFactoryBehaviour();
        }

        return $this;
    }

    public function getCommandController(array $input)
    {
        return $this->factoryBehaviour->getCommandController($input);
    }

    private function getDataTypes(): array
    {
        return ['band' => 'Band', 'venue' => 'Venue', 'city' => 'City'];
    }
}
