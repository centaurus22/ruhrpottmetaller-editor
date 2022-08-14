<?php

namespace ruhrpottmetaller\Data\LowLevel;

class RmArray implements IRmValue
{
    private array $array = array();
    private int $pointer = 0;

    public static function new(): RmArray
    {
        return new self();
    }

    public function add($value): RmArray
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

    public function pointAtNext(): RmArray
    {
        $this->pointer++;
        return $this;
    }

    public function hasCurrent(): bool
    {
        return isset($this->array[$this->pointer]);
    }
}
