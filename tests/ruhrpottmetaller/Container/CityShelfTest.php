<?php

namespace ruhrpottmetaller\Container;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Container\EventShelf;
use ruhrpottmetaller\Container\Book;

class CityShelfTest extends TestCase
{
    private EventShelf $City_Shelf;

    protected function setUp(): void
    {
        parent::setUp();
        $this->City_Shelf = new EventShelf();
    }

    public function testAddBook_ReturnsFalseIfBookMissesOneRequiredValue()
    {
        $result = $this->City_Shelf->addBook(new Book(array()));
        self::assertFalse($result);
    }

    public function testAddBook_ReturnsTrueIfOneValueIsRequiredAndAvailable()
    {
        $result = $this->City_Shelf->addBook(new Book(array("name" => "name")));
        self::assertTrue($result);
    }


    public function testAddBookGetNextBook_AddBookWithRequiredValuesAndReceiveTheSameBook()
    {
        $City_Book = new Book(array("name" => "Test"));
        $this->City_Shelf->addBook($City_Book);
        $result = $this->City_Shelf->getNextBook();
        self::assertEquals($City_Book, $result);
    }

}
