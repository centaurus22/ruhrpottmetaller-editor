<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\Band;

class DatabaseBandCommandModel extends DatabaseCommandModel
{
    public static function new(?\mysqli $connection): DatabaseBandCommandModel
    {
        return new static($connection);
    }

    public function addBand(Band $band)
    {
        $query = 'INSERT INTO band SET name = ?, is_visible = ?';
        $this->query(
            $query,
            'si',
            [
                $band->getName()->get(),
                $band->getIsVisible()->get(),
            ]
        );
    }

    public function replaceData(Band $band): void
    {
        $query = 'UPDATE band SET name = ?, is_visible = ? WHERE id = ?';
        $this->query(
            $query,
            'sii',
            [
                $band->getName()->get(),
                $band->getIsVisible()->get(),
                $band->getId()->get()
            ]
        );
    }
}
