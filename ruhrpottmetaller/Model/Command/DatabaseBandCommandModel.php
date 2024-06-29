<?php

namespace ruhrpottmetaller\Model\Command;

use mysqli;
use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\IData;

class DatabaseBandCommandModel extends DatabaseCommandModel
{
    public static function new(?mysqli $connection): DatabaseBandCommandModel
    {
        return new static($connection);
    }

    public function addBand(Band $band): void
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

    public function replaceData(IData $band): void
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
