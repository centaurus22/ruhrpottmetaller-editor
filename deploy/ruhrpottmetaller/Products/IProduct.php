<?php


namespace ruhrpottmetaller\Products;


interface IProduct
{
    public function __clone(): void;
    public function setInitialData(array $product_data): void;
    public function prepareData(): void;
}
