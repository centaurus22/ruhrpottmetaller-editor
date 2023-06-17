<?php

namespace ruhrpottmetaller\Data;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class RmArray extends AbstractRmObject implements IData
{
    private array $array = array();
    private int $pointer = 0;

    public function add($value): RmArray
    {
        $this->array[] = $value;
        return $this;
    }

    public function addAfter(RmInt $position, $value): RmArray
    {
        $firstElements = array_slice($this->array, 0, 1 + $position->get());
        $lastElements = array_slice($this->array, 1 + $position->get());
        $this->array = array_merge($firstElements, [$value], $lastElements);
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

    public function isFirst(): bool
    {
        return $this->pointer === 0;
    }
}
