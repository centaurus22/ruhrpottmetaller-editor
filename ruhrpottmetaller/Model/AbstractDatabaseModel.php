<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\RmArray;

abstract class AbstractDatabaseModel
{
    protected ?\mysqli $connection;

    public function __construct(?\mysqli $connection)
    {
        $this->connection = $connection;
    }
}
