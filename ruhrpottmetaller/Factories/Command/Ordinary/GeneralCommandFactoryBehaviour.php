<?php

namespace ruhrpottmetaller\Factories\Command\Ordinary;

use mysqli;
use ruhrpottmetaller\Controller\Command\AbstractCommandController;
use ruhrpottmetaller\Controller\Command\Ordinary\EventSaveCommandController;
use ruhrpottmetaller\Controller\Command\Ordinary\GeneralSaveCommandController;
use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\Concert;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\HighLevel\NullVenue;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Command\DatabaseCityCommandModel;
use ruhrpottmetaller\Model\Command\DatabaseVenueCommandModel;
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

        if ($input['save'] === 'event') {
            return new EventSaveCommandController(
                new $modelClass($this->connection),
                $this->getDataObject($input),
                DatabaseVenueCommandModel::new($this->connection),
                DatabaseCityCommandModel::new($this->connection)
            );
        }
        return GeneralSaveCommandController::new(
            new $modelClass($this->connection),
            $this->getDataObject($input)
        );
    }

    private function getDataObject(array $input)
    {
        switch ($input['save']) {
            case 'event':
                if ($input['length'] === '1') {
                    $event = Concert::new()
                        ->setDate(RmDate::new($input['date_start']));
                } else {
                    $event = Festival::new()
                        ->setDateStart(RmDate::new($input['date_start']))
                        ->setNumberOfDays(RmInt::new($input['length']));
                }

                if ($input['city_id'] == 1) {
                    $city = City::new()->setId(RmInt::new(1))->setName(RmString::new($input['city_new_name']));
                } elseif ($input['city_id'] > 1) {
                    $city = DatabaseCityQueryModel::new($this->connection)->getCityById(RmInt::new($input['city_id']));
                } else {
                    $city = City::new()->setId(RmInt::new($input['city_id']));
                }

                if ($input['venue_id'] == 1) {
                    $venue = Venue::new()
                        ->setId(RmInt::new(1))
                        ->setName(RmString::new($input['venue_new_name']))
                        ->setUrlDefault(RmString::new($input['url_default']))
                        ->setCity($city);
                } elseif ($input['venue_id'] > 1) {
                    $venue = DatabaseVenueQueryModel::new(
                        $this->connection,
                        DatabaseCityQueryModel::new($this->connection)
                    )->getVenueById(RmInt::new($input['venue_id']));
                } else {
                    $venue = NullVenue::new();
                }

                return $event
                    ->setId(RmInt::new($input['id']))
                    ->setName(RmString::new($input['name']))
                    ->setVenue($venue)
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
