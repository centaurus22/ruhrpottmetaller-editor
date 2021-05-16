<?php

namespace ruhrpottmetaller\Commands;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Products\ProductFactory;
use ruhrpottmetaller\Storage;

class InterpreterCommandFactoryTest extends TestCase
{
    protected ProductFactory $productFactory;
    protected Storage $commandStorage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productFactory = new ProductFactory(product_class_folder: '../../ruhrpottmetaller/Products/');
        $this->commandStorage = new Storage();
    }

    public function testFactoryMethod_addEmptyRequestArrayAndGetACommandStorage(): void
    {
        $interpreterCommandFactory = new InterpreterCommandFactory(
            $this->commandStorage,
            array(),
            $this->productFactory
        );
        $commandStorage = $interpreterCommandFactory->factoryMethod();
        self::assertInstanceOf(Storage::class, $commandStorage);
    }

    public function testFactoryMethod_addEmptyRequestAndGetACommandStorageContainingAGetCommand()
    {
        $interpreterCommandFactory = new InterpreterCommandFactory(
            $this->commandStorage,
            array(),
            $this->productFactory
        );
        $commandStorage = $interpreterCommandFactory->factoryMethod();
        self::assertInstanceOf(GetCommand::class, $commandStorage->getNextItem());
    }
}
