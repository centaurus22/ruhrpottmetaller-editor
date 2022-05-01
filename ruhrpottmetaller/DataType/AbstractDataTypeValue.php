<?php

namespace ruhrpottmetaller\DataType;

abstract class AbstractDataTypeValue implements IDataType
{
    public function __construct($value)
    {
        $this->value = $this->convertInput($value);
    }

    public static function new($value): IDataType
    {
        return new static($value);
    }

    public function set($value): IDataType
    {
        $this->value = $this->convertInput($value);
        return $this;
    }

    public function print(): IDataType
    {
        echo $this->value;
        return $this;
    }
}
