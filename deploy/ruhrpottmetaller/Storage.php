<?php

namespace ruhrpottmetaller;


use ruhrpottmetaller\Commands\AbstractCommand;
use ruhrpottmetaller\Products\IProduct;

class Storage
{
    private array $items = array();
    private int $current_item_number = 0;

    public function addItem(IProduct|AbstractCommand $item): void
    {
        $this->items[] = $item;
    }

    public function getNextItem(): IProduct|AbstractCommand|bool
    {
        if (count($this->items) > $this->current_item_number) {
            return $this->items[$this->current_item_number++];
        }
        return false;
    }
}