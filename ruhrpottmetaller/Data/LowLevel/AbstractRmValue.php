<?php

namespace ruhrpottmetaller\Data\LowLevel;

abstract class AbstractRmValue implements IRmValue
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $this->convert($value);
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

    public function print(): IRmValue
    {
        echo $this->value;
        return $this;
    }
}
