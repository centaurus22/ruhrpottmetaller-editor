<?php

namespace ruhrpottmetaller\Products;

use mysqli;
use ruhrpottmetaller\Products\IProduct;
use ruhrpottmetaller\MysqliConnect;
use ruhrpottmetaller\Storage;

abstract class AbstractGetProduct
{
    protected MysqliConnect $mysqliConnect;
    protected Storage $productStorage;
    protected IProduct $product;
    protected array $filters;
    protected string $display_type;

    public function  __construct(
        MysqliConnect $mysqliConnect,
        Storage $productStorage,
        IProduct $product,
        array $filters,
        string $display_type
    ) {
        $this->mysqliConnect = $mysqliConnect;
        $this->productStorage = $productStorage;
        $this->product = $product;
        $this->filters = $filters;
        $this->display_type = $display_type;

    }

    public function getProducts(): Storage
    {
        $mysqli = $this->mysqliConnect->getMysqli();
        $mysqliStatement = $this->getPreparedMysqliStatement(mysqli: $mysqli);
        $mysqliResult = $this->getMysqliResult(mysqliStatement: $mysqliStatement);
        $this->fillProductStorage(mysqliResult: $mysqliResult);
        return $this->productStorage;
    }

    private function getMysqliResult(\mysqli_stmt $mysqliStatement):\mysqli_result
    {
        $mysqliStatement->execute();
        $mysqliResult = $mysqliStatement->get_result();
        $mysqliStatement->close();
        return $mysqliResult;
    }

    private function fillProductStorage(\mysqli_result $mysqliResult): void
    {
        while ($product_data = $mysqliResult->fetch_assoc()) {
            $this->productStorage->addItem($this->fillProduct(product_data: $product_data));
        }
    }

    private function fillProduct(array $product_data): IProduct
    {
        $product = clone $this->product;
        $product->setInitialData($product_data);
        return $product;
    }

    abstract protected function getPreparedMysqliStatement(mysqli $mysqli);

}
