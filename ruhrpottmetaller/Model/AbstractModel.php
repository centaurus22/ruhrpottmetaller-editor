<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\RmArray;

abstract class AbstractModel
{
    protected ?\mysqli $connection;

    public function __construct(?\mysqli $connection)
    {
        $this->connection = $connection;
    }
}
