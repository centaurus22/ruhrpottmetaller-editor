<?php

namespace DataManagement;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\DataManagement\BandShelf;
use ruhrpottmetaller\DataManagement\Book;

class BandShelfTest extends TestCase
{
    private BandShelf $Band_Shelf;
    private Book $Band_Book;

    protected function setUp(): void
    {
        parent::setUp();
        $this->Band_Shelf = new BandShelf();
        $this->Band_Book = new Book();
    }

    public function testAddBook_ReturnsFalseIfBookMissesOneRequiredValue()
    {
        $result = $this->Band_Shelf->addBook($this->Band_Book);
        self::assertFalse($result);
    }

    public function testAddBook_ReturnsTrueIfOneValueIsRequiredAndAvailable()
    {
        $this->Band_Book->setDataRow(array("name" => "Test"));
        $result = $this->Band_Shelf->addBook($this->Band_Book);
        self::assertTrue($result);
    }


    public function testAddBookGetNextBook_AddBookWithRequiredValuesAndReceiveTheSameBook()
    {
        $this->Band_Book->setDataRow(array("name" => "Test"));
        $this->Band_Shelf->addBook($this->Band_Book);
        $result = $this->Band_Shelf->getNextBook();
        self::assertEquals($this->Band_Book, $result);
    }

}
