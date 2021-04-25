<?php

namespace ruhrpottmetaller\Container;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Container\Book;
use ruhrpottmetaller\Container\VenueShelf;

class VenueShelfTest extends TestCase
{
    private VenueShelf $Venue_Shelf;

    protected function setUp(): void
    {
        parent::setUp();
        $this->Venue_Shelf = new VenueShelf();
    }

    public function testAddBook_ReturnsFalseIfBookMissesOneRequiredValue()
    {
        $result = $this->Venue_Shelf->addBook(new Book(array()));
        self::assertFalse($result);
    }

    public function testAddBook_ReturnsTrueIfOneValueIsRequiredAndAvailable()
    {
        $result = $this->Venue_Shelf->addBook(new Book(array("name" => "name", "city_id" => 5)));
        self::assertTrue($result);
    }


    public function testAddBookGetNextBook_AddBookWithRequiredValuesAndReceiveTheSameBook()
    {
        $City_Book = new Book(array("name" => "Test", "city_id" => 5));
        $this->Venue_Shelf->addBook($City_Book);
        $result = $this->Venue_Shelf->getNextBook();
        self::assertEquals($City_Book, $result);
    }

}
