<?php

namespace ruhrpottmetaller;


use Exception;
use ruhrpottmetaller\Commands\AbstractCommand;
use ruhrpottmetaller\Products\IProduct;

class Storage implements IStorage
{
    private array $items = array();
    private int $pointer = 0;

    public function addItem(IProduct|AbstractCommand $item): void
    {
        $this->items[] = $item;
    }

    public function isDone(): bool
    {
        if ($this->pointer < count($this->items)) {
            return false;
        }
        return true;
    }

    public function setPointerToNextItem(): void
    {
        $this->pointer++;
    }

    public function getCurrentItem(): IProduct|AbstractCommand
    {
        if ($this->pointer < count($this->items)) {
            return $this->items[$this->pointer];
        }
        throw new Exception('Pointer references to no item.');
    }
}