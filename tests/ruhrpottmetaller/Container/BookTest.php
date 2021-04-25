<?php

namespace ruhrpottmetaller\Container;

use ruhrpottmetaller\Container\Book;
use PHPUnit\Framework\TestCase;


class BookTest extends TestCase
{
    public function testGetDataRow_SetEmptyArrayAndGetEmptyArray()
    {
        $stub = new Book(array());
        $return = $stub->GetDataRow();
        self::assertEquals(array(), $return);
    }

    public function testGetDataRow_SetArrayWithOneElementAndGetBackTheSameArray()
    {
        $stub = new Book (array("99"));
        $return = $stub->GetDataRow();
        self::assertEquals(array("99"), $return);
    }
}
