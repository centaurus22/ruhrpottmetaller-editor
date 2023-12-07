<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\Command\AbstractCommandController;
use ruhrpottmetaller\Controller\Command\Ordinary\SaveCommandController;
use ruhrpottmetaller\Controller\Command\Ordinary\NullCommandController;
use ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData;
use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class CommandFactory extends AbstractFactory
{
    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function getCommandController(array $input): AbstractCommandController
    {
        $dataTypes = $this->getDataTypes();
        if (isset($input['save']) and array_key_exists($input['save'], $dataTypes)) {
            $modelClass = 'ruhrpottmetaller\\Model\\' . $dataTypes[$input['save']] . 'CommandModel';

            return SaveCommandController::new(
                new $modelClass($this->connection),
                $this->getDataObject($input)
            );
        }

        return NullCommandController::new(null, null);
    }

    private function getDataObject(array $input): AbstractNamedHighLevelData
    {
        switch ($input['save']) {
            case 'city':
                return City::new()
                    ->setId(RmInt::new($input['id']))
                    ->setName(RmString::new($input['name']))
                    ->setIsVisible(RmBool::new($input['is_visible']));
            case 'band':
                return Band::new()
                    ->setId(RmInt::new($input['id']))
                    ->setName(RmString::new($input['name']))
                    ->setIsVisible(RmBool::new($input['is_visible']));
            case 'venue':
                return Venue::new()
                    ->setId(RmInt::new($input['id']))
                    ->setName(RmString::new($input['name']))
                    ->setUrlDefault(RmString::new($input['url_default']))
                    ->setIsVisible(RmBool::new($input['is_visible']));
        }
        throw new \Exception('Unknown data object cannot be generated.');
    }

    private function getDataTypes(): array
    {
        return ['band' => 'Band', 'venue' => 'Venue', 'city' => 'City'];
    }
}
