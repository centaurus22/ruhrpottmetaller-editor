<?php

namespace ruhrpottmetaller\Factories;

use mysqli;
use ruhrpottmetaller\Controller\Display\AbstractDisplayController;
use ruhrpottmetaller\Controller\Display\EditorMainDisplayController;
use ruhrpottmetaller\Data\HighLevel\Concert;
use ruhrpottmetaller\Data\HighLevel\Event;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\HighLevel\NullVenue;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Command\SessionGigCommandModel;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseEventQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseGigQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel;
use ruhrpottmetaller\View\View;

class EditorMainDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    private array $input;
    public function setInput(array $input): void
    {
        $this->input = $input;
    }
    public function getDisplayController(
        RmString $templatePath,
        mysqli $connection
    ): AbstractDisplayController {
        $cityQueryModel = DatabaseCityQueryModel::new($connection);
        $bandQueryModel = DatabaseBandQueryModel::new($connection);
        return new EditorMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('editor_main')
            ),
            DatabaseEventQueryModel::new(
                $connection,
                DatabaseGigQueryModel::new($connection, $bandQueryModel),
                DatabaseVenueQueryModel::new($connection, $cityQueryModel)
            ),
            SessionGigCommandModel::new($bandQueryModel),
            $this->createEvent()
        );
    }

    private function createEvent(): Event
    {
        if (isset($this->input['number_of_days']) and $this->input['number_of_days'] > 1) {
            $event = Festival::new();
            $event->setNumberOfDays(RmInt::new($this->input['number_of_days']));
            $event->setDateStart(RmDate::new($this->input['date_start'] ?? ''));
        } else {
            $event = Concert::new();
            $event->setDate(RmDate::new($this->input['date_start'] ?? ''));
        }
        $event->setId(RmInt::new($this->input['id'] ?? null));
        $event->setName(RmString::new($this->input['name'] ?? null));
        $event->setVenue(
            isset($this->input['venue_id'])
                ? Venue::new()->setId($this->input['venue_id'])
                : NullVenue::new()
        );
        $event->setUrl(RmString::new($this->input['url'] ?? null));
        return $event;
    }
}
