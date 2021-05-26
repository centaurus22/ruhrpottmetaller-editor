<?php


namespace ruhrpottmetaller\Storage;


use ruhrpottmetaller\Commands\AbstractCommand;
use ruhrpottmetaller\Products\IProduct;

interface IStorage
{
    public function addItem(IProduct|AbstractCommand $item): void;
    public function isDone(): bool;
    public function setPointerToNextItem(): void;
    public function getCurrentItem():IProduct|AbstractCommand;
}