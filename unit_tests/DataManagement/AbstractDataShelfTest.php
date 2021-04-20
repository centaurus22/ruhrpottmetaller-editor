<?php

namespace DataManagement;

use ruhrpottmetaller\DataManagement\AbstractDataShelf;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

class AbstractDataShelfTest extends TestCase
{
    private object $stub;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->stub = $this->getMockForAbstractClass(AbstractDataShelf::class);
    }

    public function testGetNextBook_ReturnsFalseIfEmptyShelf()
    {
        $result = $this->stub->getNextBook();
        self::assertFalse($result);
    }

    public function testAddBook_ReturnsTrueIfEmptyArrayProvided()
    {
        $result = $this->stub->addBook(array());
        self::assertTrue($result);
    }

    public function testAddBookGetNextBook_AfterAddingBookGetNextBookReturnsSameBook()
    {
        $this->stub->addBook(array());
        $result=$this->stub->getNextBook();
        self::assertIsArray($result);
        self::assertEquals(array(), $result);
    }

    public function testAddBookGetNextBook_AfterAddingOneBookGetOneBookAndThenFalse()
    {
        $this->stub->addBook(array(99));
        $result_1 = $this->stub->getNextBook();
        $result_2 = $this->stub->getNextBook();
        self::assertEquals(array(99), $result_1);
        self::assertEquals(false, $result_2);
    }

    public function testAddBookGetNextBook_AddTwoArraysAndGetArraysInSameSequence()
    {
        $this->stub->addBook(array(99));
        $this->stub->addBook(array(23));
        $result_1 = $this->stub->getNextBook();
        $result_2 = $this->stub->getNextBook();
        self::assertEquals(array(99), $result_1);
        self::assertEquals(array(23), $result_2);
    }
}
