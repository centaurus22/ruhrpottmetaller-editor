<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;

class EventCommandModel extends AbstractCommandModel
{
    public static function new(?\mysqli $connection): EventCommandModel
    {
        return new static($connection);
    }

    public function setSoldOut(RmInt $eventId): void
    {
        $query = 'UPDATE event SET is_sold_out = 1 WHERE id = ?';
        $this->query(
            $query,
            'i',
            [
                $eventId->get()
            ]
        );
    }

    public function delete(RmInt $eventId): void
    {
        $query = 'DELETE FROM event WHERE id = ?';
        $this->query(
            $query,
            'i',
            [
                $eventId->get()
            ]
        );
    }
}
