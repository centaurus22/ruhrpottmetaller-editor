<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\City;

class DatabaseCityCommandModel extends DatabaseCommandModel
{
    public static function new(?\mysqli $connection): DatabaseCityCommandModel
    {
        return new static($connection);
    }

    public function addCity(City $city)
    {
        $query = 'INSERT INTO city SET name = ?, is_visible = ?';
        $this->query(
            $query,
            'si',
            [$city->getName()->get(), $city->getIsVisible()->get()]
        );
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
