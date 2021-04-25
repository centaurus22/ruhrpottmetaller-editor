<?php

namespace ruhrpottmetaller\Container;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Container\EventShelf;
use ruhrpottmetaller\Container\Book;
use ruhrpottmetaller\Container\PreferencesShelf;

class PreferencesShelfTest extends TestCase
{
    private PreferencesShelf $Preferences_Shelf;

    protected function setUp(): void
    {
        parent::setUp();
        $this->Preferences_Shelf = new PreferencesShelf();
    }

    public function testAddBook_ReturnsTrueIfBookIsAdded()
    {
        $result = $this->Preferences_Shelf->addBook(new Book(array()));
        self::assertTrue($result);
    }


    public function testAddBookGetNextBook_AddBookWithRequiredValuesAndReceiveTheSameBook()
    {
        $Preferences_Book = new Book(array("name" => "Test"));
        $this->Preferences_Shelf->addBook($Preferences_Book);
        $result = $this->Preferences_Shelf->getNextBook();
        self::assertEquals($Preferences_Book, $result);
    }

}
