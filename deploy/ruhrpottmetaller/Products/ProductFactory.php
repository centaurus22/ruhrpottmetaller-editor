<?php

namespace ruhrpottmetaller\Products;

use ruhrpottmetaller\MysqliConnect;
use ruhrpottmetaller\Storage;

class ProductFactory
{
    protected string $product_class_folder;
    protected string $product_name;
    protected string $display_type;
    protected array $filters;

    public function __construct(string $product_class_folder)
    {
        $this->product_class_folder = $product_class_folder;
    }


    public function factoryMethod(): Storage
    {
        $productGetterClassName = $this->getProductGetterClassName(product_name: $this->product_name);
        $productClassName = $this->getProductClassName(product_name: $this->product_name);
        $productGetter = new $productGetterClassName(
            mysqliConnect: new MysqliConnect(db_config_file: "../../includes/db_preferences.inc.php"),
            productStorage: new Storage(),
            product: new $productClassName(),
            filters: $this->filters,
            display_type: $this->display_type
        );
        return $productGetter->getProducts();
    }

    public function setProductName($product_name):void
    {
        if ($this->isProductName(product_name: $product_name)) {
            throw new \Exception('Product name not found!');
        }
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

    protected function isProductName(string $product_name): bool
    {
        $product_class_mame = $this->getProductClassName(product_name: $product_name);
        return in_array($product_class_mame, $this->getFilesInProductClassFolder());
    }

    protected function getFilesInProductClassFolder(): array
    {
        return scandir(directory: $this->product_class_folder);
    }

    protected function getProductClassName(string $product_name): string
    {
        return ucfirst(string: $product_name) . ".php";
    }

    protected function getProductGetterClassName(string $product_name): string
    {
        return 'Get' . ucfirst(string: $product_name) . ".php";
    }


}