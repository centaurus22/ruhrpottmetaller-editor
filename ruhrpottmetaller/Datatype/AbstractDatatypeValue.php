<?php

namespace ruhrpottmetaller\Datatype;

abstract class AbstractDatatypeValue implements IDatatype
{
    public function __construct($value)
    {
        $this->value = $this->convertInput($value);
    }

    public static function new($value): IDatatype
    {
        return new static($value);
    }

    public function set($value): IDatatype
    {
        $this->value = $this->convertInput($value);
        return $this;
    }

    public function print(): IDatatype
    {
        echo $this->value;
        return $this;
    }
}
