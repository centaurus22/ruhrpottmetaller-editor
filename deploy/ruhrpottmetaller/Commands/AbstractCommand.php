<?php

namespace ruhrpottmetaller\Commands;

use ruhrpottmetaller\Products\ProductFactory;

abstract class AbstractCommand
{
    protected ProductFactory $productFactory;

    abstract public function execute();
}
