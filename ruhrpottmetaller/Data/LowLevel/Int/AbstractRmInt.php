<?php

namespace ruhrpottmetaller\Data\LowLevel\Int;

use ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

abstract class AbstractRmInt extends AbstractLowLevelDataObject
{
    public static function new($value)
    {
        return self::createObject($value);
    }

    public function get(): ?int
    {
        return $this->value;
    }

    public function asString(): AbstractRmString
    {
        return RmString::new($this->value);
    }

    public function set($value)
    {
        return self::createObject($value);
    }

    protected static function createObject($value)
    {
        if (is_null($value)) {
            return new RmNullInt(null);
        }

        return new RmInt((int) $value);
    }
}
