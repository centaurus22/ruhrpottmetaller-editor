<?php

namespace ruhrpottmetaller\DataType;

abstract class AbstractDataTypeValue implements IDataType
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

    public function set($value): IDataType
    {
        $this->value = $this->convert($value);
        return $this;
    }

    public function print(): IDataType
    {
        echo $this->value;
        return $this;
    }
}
