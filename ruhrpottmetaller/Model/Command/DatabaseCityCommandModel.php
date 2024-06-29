<?php

namespace ruhrpottmetaller\Model\Command;

use mysqli;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;

class DatabaseCityCommandModel extends DatabaseCommandModel
{
    public static function new(?mysqli $connection): DatabaseCityCommandModel
    {
        return new static($connection);
    }

    public function addCity(City $city): RmInt
    {
        $query = 'INSERT INTO city SET name = ?';
        $this->query(
            $query,
            's',
            [$city->getName()->get()]
        );
        return $this->getLastInsertedId();
    }

    public function replaceData(City $city)
    {
        $query = 'UPDATE city SET name = ?, is_visible = ? WHERE id = ?';
        $this->query(
            $query,
            'sii',
            [$city->getName()->get(), $city->getIsVisible()->get(), $city->getId()->get()]
        );
    }
}
