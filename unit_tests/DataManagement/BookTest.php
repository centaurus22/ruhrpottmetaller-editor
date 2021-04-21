<?php

namespace DataManagement;

use ruhrpottmetaller\DataManagement\Book;
use PHPUnit\Framework\TestCase;


class BookTest extends TestCase
{
    private object $stub;

    public function setUp(): void
    {
        $this->stub = new Book();
    }

    public function testGetDataRow_GetWithoutSet() {
        $return = $this->stub->getDataRow();
        self::assertEquals(array(), $return);
    }

    public function testSetGetDataRow_SetEmptyArrayAndGetEmptyArray() {
        $this->stub->SetDataRow(array());
        $return = $this->stub->GetDataRow();
        self::assertEquals(array(), $return);
    }

    public function testSetGetDataRow_SetArrayWithOneElementAndGetBackTheSameArray() {
        $this->stub->SetDataRow(array("99"));
        $return = $this->stub->GetDataRow();
        self::assertEquals(array("99"), $return);
    }

    public function testSetGetDataRow_SetArrayTwiceWithDifferentValuesAndGetTheLastArray() {
        $this->stub->SetDataRow(array("99"));
        $this->stub->SetDataRow(array("44"));
        $return = $this->stub->GetDataRow();
        self::assertEquals(array("44"), $return);
    }
}
