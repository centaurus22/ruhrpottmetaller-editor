<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\{AbstractEvent, Concert, Festival};
use ruhrpottmetaller\Data\LowLevel\{Bool\RmBool, Date\RmDate, Int\AbstractRmInt, Int\RmInt, String\RmString};
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class EventQueryModel extends AbstractQueryModel
{
    private GigQueryModel $gigQueryModel;
    private VenueQueryModel $venueQueryModel;

    public function __construct(
        ?\mysqli $connection,
        GigQueryModel $gigQueryModel,
        VenueQueryModel $venueQueryModel
    ) {
        parent::__construct($connection);
        $this->gigQueryModel = $gigQueryModel;
        $this->venueQueryModel = $venueQueryModel;
    }

    public static function new(
        ?\mysqli $connection,
        GigQueryModel $gigQueryModel,
        VenueQueryModel $venueQueryModel
    ): EventQueryModel {
        return new static($connection, $gigQueryModel, $venueQueryModel);
    }

    public function getEventsByMonth(RmDate $month): RmArray
    {
        $query = 'SELECT
                id,
                event.name AS name,
                date_start,
                number_of_days,
                venue_id,
                url,
                is_sold_out,
                is_canceled
            FROM event
            WHERE date_start LIKE ? ORDER BY date_start';
        return $this->query(
            $query,
            's',
            [$month->format('Y-m') . '%']
        );
    }

    public function getEventById(AbstractRmInt $id): AbstractEvent
    {
        $query = 'SELECT
                id,
                event.name AS name,
                date_start,
                number_of_days,
                venue_id,
                url,
                is_sold_out,
                is_canceled
            FROM event
            WHERE id LIKE ?';
        return $this->queryOne(
            $query,
            'i',
            [$id->get()]
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
            ->setId(RmInt::new($object->id))
            ->setName(RmString::new($object->name))
            ->addGigs($this->gigQueryModel->getGigsByEventId(RmInt::new($object->id)))
            ->setVenue($venue)
            ->setUrl(RmString::new($object->url))
            ->setIsSoldOut(RmBool::new($object->is_sold_out))
            ->setIsCanceled(RmBool::new($object->is_canceled));
    }
}
