<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IDataObject;

abstract class AbstractHighLevelDataObject implements IDataObject
{

    public static function new()
    {
        return new static();
    }
}