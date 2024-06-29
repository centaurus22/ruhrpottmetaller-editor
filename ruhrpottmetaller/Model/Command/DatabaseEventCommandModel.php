<?php

namespace ruhrpottmetaller\Model\Command;

use mysqli;
use ruhrpottmetaller\Data\HighLevel\Event;
use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;

class DatabaseEventCommandModel extends DatabaseCommandModel
{
    public static function new(?mysqli $connection): DatabaseEventCommandModel
    {
        return new static($connection);
    }

    public function addEvent(IData $event)
    {
        if ($event->isFestival()->get()) {
            $this->addFestival($event);
        } else {
            $this->addConcert($event);
        }
    }

    public function replaceData(Event $event): void
    {
        if ($event->isFestival()->get()) {
            $this->replaceFestival($event);
        } else {
            $this->replaceConcert($event);
        }
    }

    public function setSoldOut(RmInt $eventId): void
    {
        $query = 'UPDATE event SET is_sold_out = 1 WHERE id = ?';
        $this->query($query, 'i', [$eventId->get()]);
    }

    public function setCanceled(RmInt $eventId): void
    {
        $query = 'UPDATE event SET is_canceled = 1 WHERE id = ?';
        $this->query($query, 'i', [$eventId->get()]);
    }

    public function delete(RmInt $eventId): void
    {
        $query = 'DELETE FROM event WHERE id = ?';
        $this->query($query, 'i', [$eventId->get()]);
    }

    private function addFestival(IData $event): void
    {
        $query = 'INSERT INTO event SET name = ?, date_start = ?, number_of_days = ?, venue_id = ?, url = ?';
        $this->query( $query, 'ssiis', [
            $event->getName(),
            $event->getDateStart(),
            $event->getNumberOfDays()->get(),
            $event->getVenueId()->get(),
            $event->getUrl(),
        ]);
    }

    private function addConcert(IData $event): void
    {
        $query = 'INSERT INTO event SET name = ?, date_start = ?, number_of_days = 1, venue_id = ?, url = ?';
        $this->query( $query, 'ssis', [
            $event->getName(),
            $event->getDate(),
            $event->getVenueId()->get(),
            $event->getUrl(),
        ]);
    }

    private function replaceFestival(Event $event): void
    {
        $query = 'UPDATE event SET name = ?, date_start = ?, number_of_days = ?, venue_id = ?, url = ? WHERE id = ?';
        $this->query(
            $query,
            'ssiisi', [
            $event->getName(),
            $event->getDateStart(),
            $event->getNumberOfDays()->get(),
            $event->getVenueId()->get(),
            $event->getUrl(),
            $event->getId()->get()
        ]);
    }

    private function replaceConcert(Event $event): void
    {
        $query = 'UPDATE event SET name = ?, date_start = ?, number_of_days = 1, venue_id = ?, url = ? WHERE id = ?';
        $this->query(
            $query,
            'ssisi', [
            $event->getName(),
            $event->getDate(),
            $event->getVenueId()->get(),
            $event->getUrl(),
            $event->getId()->get()
        ]);
    }
}
