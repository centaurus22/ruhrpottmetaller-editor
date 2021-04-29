<?php

namespace ruhrpottmetaller;


use Exception;

class SideProductCreator extends AbstractProductCreator
{
    private string $product;

    public function __construct(string $product)
    {
        if (!$this->isProduct($product)) {
            throw new Exception('Product not found');
        }
        $this->product = $product;
    }

    public function factoryMethod(): ProductStorage
    {

    }

}