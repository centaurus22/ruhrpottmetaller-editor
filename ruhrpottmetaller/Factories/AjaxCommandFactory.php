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
        if ($input['command'] == 'change_gig_at') {
            $behaviour = 'ChangeGigAt';
        } elseif ($input['command'] == 'add_gig_after') {
            $behaviour = 'AddGigAfter';
        } elseif ($input['command'] == 'delete_gig_at') {
            $behaviour = 'DeleteGigAt';
        } elseif ($input['command'] == 'shift_gig_down_at') {
            $behaviour = 'ShiftGigDownAt';
        } elseif ($input['command'] == 'shift_gig_up_at') {
            $behaviour = 'ShiftGigUpAt';
        } elseif ($input['command'] == 'set_band_new_name_at') {
            $behaviour = 'SetBandNewNameAt';
        } elseif ($input['command'] == 'set_additional_information_at') {
            $behaviour = 'SetAdditionalInformationAt';
        } else {
            throw new \DomainException('Ajax call not understood');
        }

        $behaviourClass = __NAMESPACE__
            . '\\Command\\Ajax\\'
            . 'EditorAjax' . $behaviour . 'CommandFactoryBehaviour';
        $this->factoryBehaviour = new $behaviourClass($this->connection);

        return $this;
    }

    public function getCommandController(array $input): AbstractCommandController
    {
        return $this->factoryBehaviour->getCommandController($input);
    }
}
