<?php

namespace ruhrpottmetaller\Container;

use PHPUnit\Framework\TestCase;

class EventQuickUpdateShelfTest extends TestCase
{
    public EventQuickUpdateShelf $stub;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stub = new EventQuickUpdateShelf();
    }

    public function testAddBook_ReturnFalseIfBookIsEmpty()
    {
        $result = $this->stub->addBook(new Book(array()));
        self::assertFalse($result);
    }

    public function testAddBook_ReturnsFalseIfBookContainsMoreThanTwoValues()
    {
        $result = $this->stub->addBook(new Book(array("id" => 3, "name"=> "Bo", "age" => 5)));
        self::assertFalse($result);
    }

    public function testAddBook_ReturnsFalseIfBookHasNoIdValue()
    {
        $result = $this->stub->addBook(new Book(array("testNumber" => 3, "name"=>"Thorres")));
        self::assertFalse($result);
    }

    public function testAdd_ReturnsFalseIfBookHasJustOneValue()
    {
        $result = $this->stub->addBook(new Book(array("a"=> "b")));
        self::assertFalse($result);
    }

    public function testAddBook_ReturnsTrueIfBookContainsTwoValues()
    {
        $result = $this->stub->addBook(new Book(array("id" => 3, "sold_out" => true)));
        self::assertTrue($result);
    }
}
