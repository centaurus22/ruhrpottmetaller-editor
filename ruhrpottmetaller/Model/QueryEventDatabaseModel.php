<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\AbstractEvent;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\Concert;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class QueryEventDatabaseModel extends AbstractDatabaseModel
{
    /**
     * @throws \Exception
     */
    public function getEventsByMonth(RmDate $month): RmArray
    {
        $query = 'SELECT
                event.name AS name,
                date_start,
                number_of_days,
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
        $statement = $this->connection->prepare($query);
        $monthSql = $month->format('Y-m') . '%';
        $statement->bind_param('s', $monthSql);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        while ($object = $result->fetch_object()) {
            if ($object->number_of_days > 1) {
                $dataSet = Festival::new()
                       ->setDateStart(RmDate::new($object->date_start))
                       ->setNumberOfDays(RmInt::new($object->number_of_days));
            } else {
                $dataSet = Concert::new()
                       ->setDate(RmDate::new($object->date_start));
            }

            $dataSet = $this->addGeneralData($dataSet, $object);
            $this->array->add($dataSet);
        }
        return $this->array;
    }

    private function addGeneralData(
        AbstractEvent $dataSet,
        stdClass $object
    ): AbstractEvent {
        $city = City::new()
            ->setId(RmInt::new($object->city_id))
            ->setName(RmString::new($object->city_name));
        $venue = Venue::new()
            ->setId(RmInt::new($object->venue_id))
            ->setName(RmString::new($object->venue_name))
            ->setCity($city)
            ->setIsVisible(RmBool::new($object->venue_is_visible));
        return $dataSet
            ->setName(RmString::new($object->name))
           ->setVenue($venue)
           ->setUrl(RmString::new($object->url))
           ->setIsSoldOut(RmBool::new($object->is_sold_out))
           ->setIsCanceled(RmBool::new($object->is_canceled));
    }
}
