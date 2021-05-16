<?php


namespace ruhrpottmetaller\Commands;


use ruhrpottmetaller\Products\ProductFactory;
use ruhrpottmetaller\Storage;

abstract class AbstractCommandFactory
{
    protected Storage $commandStorage;
    protected ProductFactory $productFactory;

    abstract public function factoryMethod();
}