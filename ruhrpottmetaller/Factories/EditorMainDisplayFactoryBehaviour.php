<?php

namespace ruhrpottmetaller\Factories;

use ruhrpottmetaller\Controller\Display\AbstractDisplayController;
use ruhrpottmetaller\Controller\Display\EditorMainDisplayController;
use ruhrpottmetaller\Data\HighLevel\AbstractEvent;
use ruhrpottmetaller\Data\HighLevel\Concert;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\HighLevel\NullVenue;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\BandQueryModel;
use ruhrpottmetaller\Model\CityQueryModel;
use ruhrpottmetaller\Model\EventQueryModel;
use ruhrpottmetaller\Model\GigQueryModel;
use ruhrpottmetaller\Model\VenueQueryModel;
use ruhrpottmetaller\View\View;

class EditorMainDisplayFactoryBehaviour implements IGeneralDisplayFactoryBehaviour
{
    private array $input;
    public function setInput(array $input)
    {
        $this->input = $input;
    }
    public function getDisplayController(
        RmString $templatePath,
        \mysqli $connection
    ): AbstractDisplayController {
        $cityQueryModel = CityQueryModel::new($connection);
        return new EditorMainDisplayController(
            View::new(
                $templatePath,
                RmString::new('editor_main')
            ),
            EventQueryModel::new(
                $connection,
                GigQueryModel::new($connection, BandQueryModel::new($connection)),
                VenueQueryModel::new($connection, $cityQueryModel)
            ),
            $this->createEvent()
        );
    }

    private function createEvent(): AbstractEvent
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
