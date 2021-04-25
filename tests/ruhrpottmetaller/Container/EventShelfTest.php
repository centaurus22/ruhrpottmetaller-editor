<?php

namespace ruhrpottmetaller\Container;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Container\Book;
use ruhrpottmetaller\Container\EventShelf;

class EventShelfTest extends TestCase
{
    private EventShelf $Event_Shelf;

    protected function setUp(): void
    {
        parent::setUp();
        $this->Event_Shelf = new EventShelf();
    }

    public function testAddBook_ReturnsFalseIfBookMissesOneRequiredValue()
    {
        $result = $this->Event_Shelf->addBook(new Book(array()));
        self::assertFalse($result);
    }

    public function testAddBook_ReturnsTrueIfOneValueIsRequiredAndAvailable()
    {
        $result = $this->Event_Shelf->addBook(new Book(array("date" => "2020-10-11", "url" => "www.google.de")));
        self::assertTrue($result);
    }


    public function testAddBookGetNextBook_AddBookWithRequiredValuesAndReceiveTheSameBook()
    {
        $City_Book = new Book(array("date" => "2020-10-11", "url" => "www.google.de"));
        $this->Event_Shelf->addBook($City_Book);
        $result = $this->Event_Shelf->getNextBook();
        self::assertEquals($City_Book, $result);
    }
}
