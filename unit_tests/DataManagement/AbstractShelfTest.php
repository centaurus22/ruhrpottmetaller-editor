<?php

namespace DataManagement;

use ruhrpottmetaller\DataManagement\AbstractShelf;
use PHPUnit\Framework\TestCase;

use ruhrpottmetaller\DataManagement\Book;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

class AbstractShelfTest extends TestCase
{
    private object $stub;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->stub = $this->getMockForAbstractClass(AbstractShelf::class);
    }

    public function testGetNextBook_ReturnsFalseIfEmptyShelf()
    {
        $result = $this->stub->getNextBook();
        self::assertFalse($result);
    }

    public function testAddBook_ReturnsTrueIfBookObjectProvided()
    {
        $Data_Book = new Book();
        $result = $this->stub->addBook($Data_Book);
        self::assertTrue($result);
    }

    public function testAddBookGetNextBook_AfterAddingBookGetNextBookReturnsSameBook()
    {
        $Data_Book = new Book();
        $this->stub->addBook($Data_Book);
        $result = $this->stub->getNextBook();
        self::assertIsObject($result);
        self::assertEquals($Data_Book, $result);
    }

    public function testAddBookGetNextBook_AfterAddingOneBookGetOneBookAndThenFalse()
    {
        $Data_Book = new Book();
        $this->stub->addBook($Data_Book);
        $result_1 = $this->stub->getNextBook();
        $result_2 = $this->stub->getNextBook();
        self::assertEquals($Data_Book, $result_1);
        self::assertEquals(false, $result_2);
    }

    public function testAddBookGetNextBook_AddTwoArraysAndGetArraysInSameSequence()
    {
        $Data_Book_1 = new Book();
        $Data_Book_1->setDataRow(array("99"));
        $Data_Book_2 = new Book();
        $Data_Book_2->setDataRow(array("23"));
        $this->stub->addBook($Data_Book_1);
        $this->stub->addBook($Data_Book_2);
        $Result_Object_1 = $this->stub->getNextBook();
        $Result_Object_2 = $this->stub->getNextBook();
        $result_1 = $Result_Object_1->getDataRow();
        $result_2 = $Result_Object_2->getDataRow();
        self::assertEquals(array("99"), $result_1);
        self::assertEquals(array("23"), $result_2);
    }
}
