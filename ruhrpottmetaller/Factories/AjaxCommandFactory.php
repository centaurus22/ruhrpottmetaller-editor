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
            $behaviour = 'EditorAjaxChangeGigAt';
        } elseif ($input['command'] == 'add_gig_after') {
                $behaviour = 'EditorAjaxAddGigAfter';
        } elseif ($input['command'] == 'delete_gig_at') {
            $behaviour = 'EditorAjaxDeleteGigAt';
        } elseif ($input['command'] == 'shift_gig_down_at') {
            $behaviour = 'EditorAjaxShiftGigDownAt';
        } elseif ($input['command'] == 'shift_gig_up_at') {
            $behaviour = 'EditorAjaxShiftGigUpAt';
        } elseif ($input['command'] == 'set_band_name_at') {
            $behaviour = 'EditorAjaxSetBandNameAt';
        } elseif ($input['command'] == 'set_additional_information_at') {
            $behaviour = 'EditorAjaxSetAdditionalInformationAt';
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
