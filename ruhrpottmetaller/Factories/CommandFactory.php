<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Factories\Command\Ordinary\GeneralCommandFactoryBehaviour;
use ruhrpottmetaller\Factories\Command\Ordinary\NullCommandFactoryBehaviour;
use ruhrpottmetaller\Factories\Command\Ordinary\SetCanceledCommandFactoryBehaviour;
use ruhrpottmetaller\Factories\Command\Ordinary\SetSoldOutCommandFactoryBehaviour;

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
        } elseif (isset($input['action']) and $input['action'] == 'set-canceled') {
            $this->factoryBehaviour = new SetCanceledCommandFactoryBehaviour($this->connection);}
        elseif (isset($input['action']) and $input['action'] == 'set-sold-out') {
            $this->factoryBehaviour = new SetSoldOutCommandFactoryBehaviour($this->connection);
        } else {
            $this->factoryBehaviour =  new NullCommandFactoryBehaviour();
        }

        return $this;
    }

    public function getCommandController(array $input)
    {
        return $this->factoryBehaviour->getCommandController($input);
    }
}
