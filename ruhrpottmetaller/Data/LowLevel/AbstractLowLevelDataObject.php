<?php

namespace ruhrpottmetaller\Data\LowLevel;

use ruhrpottmetaller\Data\IDataObject;

abstract class AbstractLowLevelDataObject implements IDataObject
{
    protected $value;

    protected function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
