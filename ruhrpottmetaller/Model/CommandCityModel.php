<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\City;

class CommandCityModel extends AbstractCommandModel
{
    public static function new(?\mysqli $connection): CommandCityModel
    {
        return new static($connection);
    }

    public function replaceCity(City $city)
    {
        $query = 'UPDATE city SET name = ?, is_visible = ? WHERE id = ?';
        $this->query(
            $query,
            'sii',
            [$city->getName()->get(), $city->getIsVisible()->get(), $city->getId()->get()]
        );
    }
}
