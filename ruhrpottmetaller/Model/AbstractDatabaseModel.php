<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\LowLevel\DataTypeArray;

abstract class AbstractDatabaseModel
{
    protected \mysqli $Connection;
    protected DataTypeArray $Array;

    public function __construct(\mysqli $Connection, DataTypeArray $Array)
    {
        $this->Connection = $Connection;
        $this->Array = $Array;
    }

    public static function new(\mysqli $Connection, DataTypeArray $Array): AbstractDatabaseModel
    {
        return new static($Connection, $Array);
    }
}
