<?php

namespace ruhrpottmetaller\Data\LowLevel;

use ruhrpottmetaller\Data\IDataObject;

abstract class AbstractLowLevelDataObject implements IDataObject
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $this->convert($value);
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    public static function new($value)
    {
        return new static($value);
    }

    public function set($value)
    {
        $this->value = $this->convert($value);
        return $this;
    }
}
