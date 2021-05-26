<?php

namespace ruhrpottmetaller\Products;

use ruhrpottmetaller\MysqliConnect;
use ruhrpottmetaller\Storage\Storage;

class ProductFactory
{
    protected string $product_name;
    protected string $display_type;
    protected array $filters;

    public function factoryMethod(): AbstractProductEnvironment
    {
        $namespace = "ruhrpottmetaller\\Products\\";
        $productEnvironmentClassName = $namespace . $this->getProductEnvironmentClassName(product_name: $this->product_name);
        $productClassName = $namespace . $this->getProductClassName(product_name: $this->product_name);
        return new $productEnvironmentClassName(
            mysqliConnect: new MysqliConnect(),
            productStorage: new Storage(),
            product: new $productClassName(),
            filters: $this->filters,
            display_type: $this->display_type
        );
    }

    public function setProductName($product_name):void
    {
        $this->product_name = $product_name;
    }

    public function setFilters($filters):void
    {
        $this->filters = $filters;
    }

    public function setDisplayType($display_type):void
    {
        $this->display_type = $display_type;
    }

    protected function getProductClassName(string $product_name): string
    {
        return ucfirst(string: $product_name);
    }

    protected function getProductEnvironmentClassName(string $product_name): string
    {
        return ucfirst(string: $product_name) . 'Environment';
    }
}
