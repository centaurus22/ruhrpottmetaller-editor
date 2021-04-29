<?php

namespace ruhrpottmetaller;

abstract class AbstractProductCreator
{
    private const PRODUCT_CLASS_FOLDER = "ruhrpottmetaller/";

    abstract public function factoryMethod(): ProductStorage;

    protected function isProduct(string $product): bool
    {
        $productClassName = ucfirst(string: $product) . "Product" . ".php";
        return in_array($productClassName, $this->getFilesInProductClassFolder());
    }

    protected function getFilesInProductClassFolder(): array
    {
        return scandir(directory: self::PRODUCT_CLASS_FOLDER);
    }

}