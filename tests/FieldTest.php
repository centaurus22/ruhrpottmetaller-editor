<?php


use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{

    public function testGetValueGetSameValueAfterItIsSetDuringInitialisation()
    {
        $stub = new ruhrpottmetaller\Field(value: "99", description: "Number of Balloons");
        self::assertEquals("99", $stub->getValue());
    }

    public function testGetDescription_GetSameValueAfterItIsSetDuringInitialisation()
    {
        $stub = new ruhrpottmetaller\Field(value: 99, description: "Number of Balloons");
        self::assertEquals("Number of Balloons", $stub->getDescription());
    }
}
