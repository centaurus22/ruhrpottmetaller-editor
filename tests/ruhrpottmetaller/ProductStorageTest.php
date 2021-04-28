<?php

namespace ruhrpottmetaller;

use PHPUnit\Framework\TestCase;

class ProductStorageTest extends TestCase
{
    public function testGetNextProduct_ReturnsMinusOneIfNoProductIsAddedBefore()
    {
        $productStorage = new ProductStorage();
        self::assertFalse($productStorage->getNextProduct());
    }

    public function testGetNextProduct_ReturnsSameProductIfProductIsAddedBefore()
    {
        $productStorage = new ProductStorage();
        $product = new BandProduct();
        $productStorage->addProduct($product);
        self::assertEquals($product, $productStorage->getNextProduct());
    }

    public function testGetNextProduct_ReturnFirstProductIfTwoProductsAreAddedBefore()
    {
        $productStorage = new ProductStorage();
        $product_1 = new BandProduct();
        $product_2 = new AbstractProduct();
        $productStorage->addProduct($product_1);
        $productStorage->addProduct($product_2);
        self::assertEquals($product_1, $productStorage->getNextProduct());
    }

    public function testGetNextProduct_ReturnTowProductsInTheSameSequenceTheyAreProvided()
    {
        $productStorage = new ProductStorage();
        $product1 = new BandProduct();
        $product2 = new AbstractProduct();
        $productStorage->addProduct($product1);
        $productStorage->addProduct($product2);
        self::assertEquals($product1, $productStorage->getNextProduct());
        self::assertEquals($product2, $productStorage->getNextProduct());
    }

    public function testGetNextProduct_ReturnFalseAfterOneProductIsProvidedAndTwoAreRequested()
    {
        $productStorage = new ProductStorage();
        $productStorage->addProduct(new BandProduct());
        $productStorage->getNextProduct();
        self::assertFalse($productStorage->getNextProduct());


    }
}
