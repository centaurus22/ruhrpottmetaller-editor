<?php

namespace ruhrpottmetaller\Factories\Command\Ordinary;

use mysqli;
use ruhrpottmetaller\Controller\Command\AbstractCommandController;
use ruhrpottmetaller\Controller\Command\Ordinary\SaveCommandController;
use ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData;
use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\Concert;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel;

class GeneralCommandFactoryBehaviour
{
    private mysqli $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function getCommandController(array $input): AbstractCommandController
    {
        $modelClass = 'ruhrpottmetaller\\Model\\Command\\Database' . ucfirst($input['save']) . 'CommandModel';

        return SaveCommandController::new(
            new $modelClass($this->connection),
            $this->getDataObject($input)
        );
    }

    private function getDataObject(array $input): AbstractNamedHighLevelData
    {
        switch ($input['save']) {
            case 'concert':
                if ($input['length'] === 1) {
                    $event = Concert::new()
                        ->setDate(RmDate::new($input['date_start']));
                } else {
                    $event = Festival::new()
                        ->setDateStart(RmDate::new($input['date_start']))
                        ->setNumberOfDays(RmInt::new($input['length']));
                }

                if ($input['city_id'] == 1) {
                    $city = City::new();
                } else {
                    
                }

                if ($input['venue_id'] == 1) {
                    $venue = Venue::new();
                } else {
                    $venue = DatabaseVenueQueryModel::new(
                        $this->connection,
                        DatabaseCityQueryModel::new($this->connection)
                    )->getVenueById(RmInt::new($input['venue_id']));
                }

                return $event
                    ->setName(RmString::new($input['name']))
                    ->setUrl(RmString::new($input['url']));
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
}
