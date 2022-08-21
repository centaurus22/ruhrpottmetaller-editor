<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\AbstractEvent;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\Concert;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\RmBool;
use ruhrpottmetaller\Data\LowLevel\RmDate;
use ruhrpottmetaller\Data\LowLevel\RmInt;
use ruhrpottmetaller\Data\LowLevel\RmString;
use ruhrpottmetaller\Data\RmArray;

class QueryEventDatabaseModel extends AbstractDatabaseModel
{
    public function __construct(\mysqli $Connection, RmArray $Array)
    {
        parent::__construct($Connection, $Array);
    }

    public function getEventsByMonth(RmString $Month): RmArray
    {
        $query = 'SELECT
                event.name AS name,
                date_start,
                number_days,
                venue.id AS venue_id,
                venue.name AS venue_name,
                venue.is_visible AS venue_is_visible,
                city.id AS city_id,
                city.name AS city_name,
                url,
                is_sold_out,
                is_canceled
            FROM event
            LEFT JOIN venue ON event.venue_id = venue.id
            LEFT JOIN city ON venue.city_id = city.id
            WHERE date_start LIKE ?';
        $Statement = $this->Connection->prepare($query);
        $month = $Month->get() . '%';
        $Statement->bind_param('s', $month);
        $Statement->execute();
        $Result = $Statement->get_result();
        $Statement->close();

        while ($Object = $Result->fetch_object()) {
            if ($Object->number_days > 1) {
                $DataSet = Festival::new()
                       ->setDateStart(RmDate::new($Object->date_start))
                       ->setNumberOfDays(RmInt::new($Object->number_days));
            } else {
                $DataSet = Concert::new()
                       ->setDate(RmDate::new($Object->date_start));
            }

            $DataSet = $this->addGeneralData($DataSet, $Object);
            $this->Array->add($DataSet);
        }
        return $this->Array;
    }

    private function addGeneralData(
        AbstractEvent $DataSet,
        \stdClass     $Object
    ): AbstractEvent {
        $City = City::new()
            ->setId(RmInt::new($Object->city_id))
            ->setName(RmString::new($Object->city_name));
        $Venue = Venue::new()
            ->setId(RmInt::new($Object->venue_id))
            ->setName(RmString::new($Object->venue_name))
            ->setCity($City)
            ->setIsVisible(RmBool::new($Object->venue_is_visible));
        return $DataSet
            ->setName(RmString::new($Object->name))
           ->setVenue($Venue)
           ->setUrl(RmString::new($Object->url))
           ->setIsSoldOut(RmBool::new($Object->is_sold_out))
           ->setIsCanceled(RmBool::new($Object->is_canceled));
    }
}
