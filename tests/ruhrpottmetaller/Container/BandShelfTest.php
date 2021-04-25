<?php

namespace ruhrpottmetaller\Container;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Container\BandShelf;
use ruhrpottmetaller\Container\Book;

class BandShelfTest extends TestCase
{
    private BandShelf $Band_Shelf;

    protected function setUp(): void
    {
        parent::setUp();
        $this->Band_Shelf = new BandShelf();
    }

    public function testAddBook_ReturnsFalseIfBookMissesOneRequiredValue()
    {
        $result = $this->Band_Shelf->addBook(new Book(array()));
        self::assertFalse($result);
    }

    public function testAddBook_ReturnsTrueIfOneValueIsRequiredAndAvailable()
    {
        $result = $this->Band_Shelf->addBook(new Book(array("name" => "Test")));
        self::assertTrue($result);
    }


    public function testAddBookGetNextBook_AddBookWithRequiredValuesAndReceiveTheSameBook()
    {
        $Band_Book = new Book(array("name" => "Test"));
        $this->Band_Shelf->addBook($Band_Book);
        $result = $this->Band_Shelf->getNextBook();
        self::assertEquals($Band_Book, $result);
    }

}
