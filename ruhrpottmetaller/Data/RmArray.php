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

    public function set(RmInt $position, $value): RmArray
    {
        $this->array[$position->get()] = $value;
        return $this;
    }

    public function addAfter(RmInt $position, $value): RmArray
    {
        $firstElements = array_slice($this->array, 0, 1 + $position->get());
        $lastElements = array_slice($this->array, 1 + $position->get());
        $this->array = array_merge($firstElements, [$value], $lastElements);
        return $this;
    }

    public function delete(RmInt $position): RmArray
    {
        unset($this->array[$position->get()]);
        $this->array = array_values($this->array);
        return $this;
    }

    public function switch(RmInt $position1, RmInt $position2): RmArray
    {
        if (!isset($this->array[$position1->get()]) or !isset($this->array[$position2->get()])) {
            return $this;
        }

        $element = $this->array[$position1->get()];
        $this->array[$position1->get()] = $this->array[$position2->get()];
        $this->array[$position2->get()] = $element;
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
