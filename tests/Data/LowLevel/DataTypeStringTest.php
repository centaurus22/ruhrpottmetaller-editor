<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\DataTypeString;

final class DataTypeStringTest extends TestCase
{
    public \ruhrpottmetaller\Data\LowLevel\DataTypeString $String;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShoudReturnEmptyStringAfterAcceptingEmptyString(): void
    {
        $this->String = new \ruhrpottmetaller\Data\LowLevel\DataTypeString('');
        $this->assertEquals('', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShoudReturnSameStringAfterAcceptingString(): void
    {
        $this->String = new \ruhrpottmetaller\Data\LowLevel\DataTypeString('Festival');
        $this->assertEquals('Festival', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = new \ruhrpottmetaller\Data\LowLevel\DataTypeString(33);
        $this->assertEquals('33', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testGetItShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = new \ruhrpottmetaller\Data\LowLevel\DataTypeString('');
        $this->String->set(42);
        $this->assertEquals('42', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->String = new \ruhrpottmetaller\Data\LowLevel\DataTypeString(null);
        $this->assertTrue(is_null($this->String->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldReturnNullAfterAcceptingNullBySetId(): void
    {
        $this->String = new \ruhrpottmetaller\Data\LowLevel\DataTypeString('');
        $this->String->set(null);
        $this->assertTrue(is_null($this->String->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldOutputStringAfterAccepting(): void
    {
        $this->expectOutputString('Band');
        $this->String = new \ruhrpottmetaller\Data\LowLevel\DataTypeString('Band');
        $this->String->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->String = new \ruhrpottmetaller\Data\LowLevel\DataTypeString(null);
        $this->String->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testNewShouldAcceptStringAndGetShouldProvideItAgain(): void
    {
        $this->String = \ruhrpottmetaller\Data\LowLevel\DataTypeString::new('Venue');
        $this->assertEquals('Venue', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(
            'City',
            DataTypeString::new('Venue')->set('City')->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShoultPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('VenueConcert');
        DataTypeString::new('Venue')->print()->set('Concert')->print();
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShoultGetTheValueFromTheLastChainedSet(): void
    {
        $this->String = DataTypeString::new('Venue')->set('Darkness');
        $this->assertEquals('Darkness', $this->String->get());
    }
}
