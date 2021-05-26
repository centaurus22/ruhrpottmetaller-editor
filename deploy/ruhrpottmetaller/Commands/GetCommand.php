<?php


namespace ruhrpottmetaller\Commands;

use ruhrpottmetaller\Products\ProductFactory;

class GetCommand extends AbstractCommand
{
    public function __construct(
        ProductFactory $productFactory,
    ) {
        $this->productFactory = $productFactory;
    }

    public function execute()
    {
        $productEnvironment = $this->productFactory->factoryMethod();
        $productStorage = $productEnvironment->getProducts();
        while (!$productStorage->isDone())
        {
            $productStorage->getCurrentItem()->prepareData();
            $productStorage->setPointerToNextItem();
        }
    }
}
