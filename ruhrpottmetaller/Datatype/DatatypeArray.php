<?php

namespace ruhrpottmetaller\Datatype;

class DatatypeArray implements IDatatype
{
    private array $array = array();
    private int $pointer = 0;

    public static function new(): DatatypeArray
    {
        return new self();
    }

    public function add($value)
    {
        $this->array[] = $value;
        return $this;
    }

    public function get()
    {
        if (!isset($this->array[$this->pointer])) {
            throw new \Error('The Array does not contain data at this position.');
        }
        return $this->array[$this->pointer];
    }

    public function pointAtNext()
    {
        $this->pointer++;
        return $this;
    }

    public function isCurrent(): bool
    {
        return isset($this->array[$this->pointer]);
    }
}
