<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\DataType;

use ruhrpottmetaller\DataType\DataTypeString;
use PHPUnit\Framework\TestCase;

final class DataTypeStringTest extends TestCase
{
    public \ruhrpottmetaller\DataType\DataTypeString $String;

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString::__construct
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue::__construct
     * @covers \ruhrpottmetaller\DataType\DataTypeString::get
     * @covers \ruhrpottmetaller\DataType\DataTypeString::convertInput
     */
    public function testShoudReturnEmptyStringAfterAcceptingEmptyString(): void
    {
        $this->String = new \ruhrpottmetaller\DataType\DataTypeString('');
        $this->assertEquals('', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString::__construct
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue::__construct
     * @covers \ruhrpottmetaller\DataType\DataTypeString::get
     * @covers \ruhrpottmetaller\DataType\DataTypeString::convertInput
     */
    public function testShoudReturnSameStringAfterAcceptingString(): void
    {
        $this->String = new \ruhrpottmetaller\DataType\DataTypeString('Festival');
        $this->assertEquals('Festival', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString::__construct
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue::__construct
     * @covers \ruhrpottmetaller\DataType\DataTypeString::get
     * @covers \ruhrpottmetaller\DataType\DataTypeString::convertInput
     */
    public function testShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = new \ruhrpottmetaller\DataType\DataTypeString(33);
        $this->assertEquals('33', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString::__construct
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue::__construct
     * @covers \ruhrpottmetaller\DataType\DataTypeString::get
     * @covers \ruhrpottmetaller\DataType\DataTypeString::set
     * @covers \ruhrpottmetaller\DataType\DataTypeString::convertInput
     */
    public function testGetItShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = new \ruhrpottmetaller\DataType\DataTypeString('');
        $this->String->set(42);
        $this->assertEquals('42', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString::__construct
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue::__construct
     * @covers \ruhrpottmetaller\DataType\DataTypeString::get
     * @covers \ruhrpottmetaller\DataType\DataTypeString::convertInput
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->String = new \ruhrpottmetaller\DataType\DataTypeString(null);
        $this->assertTrue(is_null($this->String->get()));
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString::__construct
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue::__construct
     * @covers \ruhrpottmetaller\DataType\DataTypeString::get
     * @covers \ruhrpottmetaller\DataType\DataTypeString::set
     * @covers \ruhrpottmetaller\DataType\DataTypeString::convertInput
     */
    public function testShouldReturnNullAfterAcceptingNullBySetId(): void
    {
        $this->String = new \ruhrpottmetaller\DataType\DataTypeString('');
        $this->String->set(null);
        $this->assertTrue(is_null($this->String->get()));
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString::__construct
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue::__construct
     * @covers \ruhrpottmetaller\DataType\DataTypeString::print
     * @covers \ruhrpottmetaller\DataType\DataTypeString::convertInput
     */
    public function testShouldOutputStringAfterAccepting(): void
    {
        $this->expectOutputString('Band');
        $this->String = new \ruhrpottmetaller\DataType\DataTypeString('Band');
        $this->String->Print();
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString::__construct
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue::__construct
     * @covers \ruhrpottmetaller\DataType\DataTypeString::print
     * @covers \ruhrpottmetaller\DataType\DataTypeString::convertInput
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->String = new \ruhrpottmetaller\DataType\DataTypeString(null);
        $this->String->Print();
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString::__construct
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue::__construct
     * @covers \ruhrpottmetaller\DataType\DataTypeString::convertInput
     * @covers \ruhrpottmetaller\DataType\DataTypeString::new
     * @covers \ruhrpottmetaller\DataType\DataTypeString::get
     */
    public function testNewShouldAcceptStringAndGetShouldProvideItAgain(): void
    {
        $this->String = \ruhrpottmetaller\DataType\DataTypeString::new('Venue');
        $this->assertEquals('Venue', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString::__construct
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue::__construct
     * @covers \ruhrpottmetaller\DataType\DataTypeString::convertInput
     * @covers \ruhrpottmetaller\DataType\DataTypeString::new
     * @covers \ruhrpottmetaller\DataType\DataTypeString::get
     * @covers \ruhrpottmetaller\DataType\DataTypeString::set
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(
            'City',
            DataTypeString::new('Venue')->set('City')->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString::__construct
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue::__construct
     * @covers \ruhrpottmetaller\DataType\DataTypeString::convertInput
     * @covers \ruhrpottmetaller\DataType\DataTypeString::new
     * @covers \ruhrpottmetaller\DataType\DataTypeString::print
     * @covers \ruhrpottmetaller\DataType\DataTypeString::set
     */
    public function testShoultPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('VenueConcert');
        DataTypeString::new('Venue')->print()->set('Concert')->print();
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeString::__construct
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue::__construct
     * @covers \ruhrpottmetaller\DataType\DataTypeString::convertInput
     * @covers \ruhrpottmetaller\DataType\DataTypeString::new
     * @covers \ruhrpottmetaller\DataType\DataTypeString::set
     * @covers \ruhrpottmetaller\DataType\DataTypeString::get
     */
    public function testShoultGetTheValueFromTheLastChainedSet(): void
    {
        $this->String = DataTypeString::new('Venue')->set('Darkness');
        $this->assertEquals('Darkness', $this->String->get());
    }
}
