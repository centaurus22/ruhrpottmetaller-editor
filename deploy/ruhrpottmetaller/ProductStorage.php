<?php

namespace ruhrpottmetaller;

class ProductStorage
{
    private array $products = array();
    private int $current_product_number = 0;

    public function addProduct(AbstractProduct $product): void
    {
        $this->products[] = $product;
    }

    public function getNextProduct(): AbstractProduct|bool
    {
        if (count($this->products) > $this->current_product_number) {
            return $this->products[$this->current_product_number++];
        }
        return false;
    }

    public function replaceCurrentProduct(AbstractProduct $product)
    {

    }

}