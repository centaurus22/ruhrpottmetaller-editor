<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class CommandCityModel extends AbstractModel
{
    public static function new(?\mysqli $connection): CommandCityModel
    {
        return new static($connection);
    }

    public function updateCity(RmInt $id, RmString $name, AbstractRmBool $isVisible)
    {
        $query = 'UPDATE city SET name = ?, is_visible = ? WHERE id = ?';
        $statement = $this->connection->prepare($query);
        $isVisibleSql = $isVisible->get();
        $idSql = $id->get();
        $statement->bind_param('sii', $name, $isVisibleSql, $idSql);
        $statement->execute();
        $statement->close();
    }
}
