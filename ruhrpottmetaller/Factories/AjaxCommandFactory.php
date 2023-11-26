<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\Command\AbstractCommandController;

class AjaxCommandFactory extends AbstractFactory
{
    private object $factoryBehaviour;

    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function setFactoryBehaviour(array $input): AjaxCommandFactory
    {
        if (isset($input['command']) and $input['command'] == 'change_gig_at') {
            $behaviour = 'EditorAjaxChangeGigAt';
        } else {
            throw new \DomainException('Ajax call not understood');
        }

        $behaviourClass = __NAMESPACE__
            . '\\AjaxFactoryBehaviour\\'
            . $behaviour . 'CommandFactoryBehaviour';
        $this->factoryBehaviour = new $behaviourClass($this->connection);

        return $this;
    }

    public function getCommandController(array $input): AbstractCommandController
    {
        return $this->factoryBehaviour->getCommandController($input);
    }
}
