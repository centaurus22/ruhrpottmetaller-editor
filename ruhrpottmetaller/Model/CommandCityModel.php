<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class CommandCityModel extends AbstractCommandModel
{
    public static function new(?\mysqli $connection): CommandCityModel
    {
        return new static($connection);
    }

    public function updateCity(RmInt $id, RmString $name, AbstractRmBool $isVisible)
    {
        $query = 'UPDATE city SET name = ?, is_visible = ? WHERE id = ?';
        $this->query(
            $query,
            'sii',
            [$name->get(), $isVisible->get(), $id->get()]
        );
    }
}
