<?php

namespace ruhrpottmetaller\DataType;

class DataTypeArray implements IDataType
{
    private array $array = array();
    private int $pointer = 0;

    public static function new(): DataTypeArray
    {
        return new self();
    }

    public function add($value): DataTypeArray
    {
        $this->array[] = $value;
        return $this;
    }

    public function getCurrent()
    {
        if (!isset($this->array[$this->pointer])) {
            throw new \Error('The Array does not contain data at this position.');
        }
        return $this->array[$this->pointer];
    }

    public function pointAtNext(): DataTypeArray
    {
        $this->pointer++;
        return $this;
    }

    public function hasCurrent(): bool
    {
        return isset($this->array[$this->pointer]);
    }
}
