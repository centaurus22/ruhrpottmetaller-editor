<?php

namespace ruhrpottmetaller;

use mysqli;
use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Commands\GetCommand;
use ruhrpottmetaller\Products\Band;
use ruhrpottmetaller\Products\ProductFactory;

class StorageTest extends TestCase
{
    public ProductFactory $productFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productFactory = new ProductFactory();
    }

    public function testGetNextProduct_ReturnsMinusOneIfNoProductIsAddedBefore()
    {
        $productStorage = new Storage();
        self::assertFalse($productStorage->getNextItem());
    }

    public function testGetNextProduct_ReturnsSameProductIfProductIsAddedBefore()
    {
        $itemStorage = new Storage();
        $product = new Band();
        $itemStorage->addItem($product);
        self::assertEquals($product, $itemStorage->getNextItem());
    }

    public function testGetNextProduct_ReturnFirstProductIfTwoProductsAreAddedBefore()
    {
        $productStorage = new Storage();
        $product_1 = new Band();
        $product_2 = new GetCommand($this->productFactory);
        $productStorage->addItem($product_1);
        $productStorage->addItem($product_2);
        self::assertEquals($product_1, $productStorage->getNextItem());
    }

    public function testGetNextProduct_ReturnTowProductsInTheSameSequenceTheyAreProvided()
    {
        $productStorage = new Storage();
        $product1 = new Band();
        $product2 = new GetCommand($this->productFactory);
        $productStorage->addItem($product1);
        $productStorage->addItem($product2);
        self::assertEquals($product1, $productStorage->getNextItem());
        self::assertEquals($product2, $productStorage->getNextItem());
    }

    public function testGetNextProduct_ReturnFalseAfterOneProductIsProvidedAndTwoAreRequested()
    {
        $productStorage = new Storage();
        $productStorage->addItem(new Band());
        $productStorage->getNextItem();
        self::assertFalse($productStorage->getNextItem());
    }
}
