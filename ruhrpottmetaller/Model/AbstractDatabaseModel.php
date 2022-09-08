<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\RmArray;

abstract class AbstractDatabaseModel
{
    protected ?\mysqli $Connection;
    protected ?RmArray $Array;

    public function __construct(?\mysqli $Connection, ?RmArray $Array)
    {
        $this->Connection = $Connection;
        $this->Array = $Array;
    }

    public static function new(?\mysqli $Connection, ?RmArray $Array)
    {
        return new static($Connection, $Array);
    }
}
