<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\LowLevel\Int\RmInt;

class DatabaseEventCommandModel extends DatabaseCommandModel
{
    public static function new(?\mysqli $connection): DatabaseEventCommandModel
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

    public function setCanceled(RmInt $eventId): void
    {
        $query = 'UPDATE event SET is_canceled = 1 WHERE id = ?';
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
