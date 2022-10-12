<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\RmArray;

abstract class AbstractDatabaseModel
{
    protected ?\mysqli $connection;
    protected ?RmArray $array;

    public function __construct(?\mysqli $connection, ?RmArray $array)
    {
        $this->connection = $connection;
        $this->array = $array;
    }

    public static function new(?\mysqli $connection, ?RmArray $array)
    {
        return new static($connection, $array);
    }
}
