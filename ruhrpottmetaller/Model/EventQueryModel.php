<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\{AbstractEvent, Concert, Festival};
use ruhrpottmetaller\Data\LowLevel\{
    Bool\RmBool,
    Date\RmDate,
    Int\RmInt,
    String\RmString
};
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class EventQueryModel extends AbstractQueryModel
{
    private VenueQueryModel $venueQueryModel;

    public function __construct(
        ?\mysqli $connection,
        VenueQueryModel $queryVenueModel
    ) {
        parent::__construct($connection);
        $this->venueQueryModel = $queryVenueModel;
    }

    public static function new(
        ?\mysqli $connection,
        VenueQueryModel $queryVenueModel
    ): EventQueryModel {
        return new static($connection, $queryVenueModel);
    }

    public function getEventsByMonth(RmDate $month): RmArray
    {
        $query = 'SELECT
                event.name AS name,
                date_start,
                number_of_days,
                venue_id,
                url,
                is_sold_out,
                is_canceled
            FROM event
            WHERE date_start LIKE ? ORDER BY date_start;';
        return $this->query(
            $query,
            's',
            [$month->format('Y-m') . '%']
        );
    }

    protected function getDataFromResult(stdClass $object): AbstractEvent
    {
        if ($object->number_of_days > 1) {
            $event = Festival::new()
                ->setDateStart(RmDate::new($object->date_start))
                ->setNumberOfDays(RmInt::new($object->number_of_days));
        } else {
            $event = Concert::new()
                ->setDate(RmDate::new($object->date_start));
        }

        return $this->addGeneralData($event, $object);
    }

    protected function addGeneralData(
        AbstractEvent $event,
        stdClass $object
    ): AbstractEvent {
        $venue = $this->venueQueryModel
            ->getVenueById(RmInt::new($object->venue_id));
        return $event
           ->setName(RmString::new($object->name))
           ->setVenue($venue)
           ->setUrl(RmString::new($object->url))
           ->setIsSoldOut(RmBool::new($object->is_sold_out))
           ->setIsCanceled(RmBool::new($object->is_canceled));
    }
}
