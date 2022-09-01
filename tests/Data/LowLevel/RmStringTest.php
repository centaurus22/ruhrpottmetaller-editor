<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\RmString;

final class RmStringTest extends TestCase
{
    public \ruhrpottmetaller\Data\LowLevel\RmString $String;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShoudReturnEmptyStringAfterAcceptingEmptyString(): void
    {
        $this->String = new \ruhrpottmetaller\Data\LowLevel\RmString('');
        $this->assertEquals('', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShoudReturnSameStringAfterAcceptingString(): void
    {
        $this->String = new \ruhrpottmetaller\Data\LowLevel\RmString('Festival');
        $this->assertEquals('Festival', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = new \ruhrpottmetaller\Data\LowLevel\RmString(33);
        $this->assertEquals('33', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testGetItShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = new \ruhrpottmetaller\Data\LowLevel\RmString('');
        $this->String->set(42);
        $this->assertEquals('42', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->String = new \ruhrpottmetaller\Data\LowLevel\RmString(null);
        $this->assertTrue(is_null($this->String->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnNullAfterAcceptingNullBySetId(): void
    {
        $this->String = new \ruhrpottmetaller\Data\LowLevel\RmString('');
        $this->String->set(null);
        $this->assertTrue(is_null($this->String->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputStringAfterAccepting(): void
    {
        $this->expectOutputString('Band');
        $this->String = new \ruhrpottmetaller\Data\LowLevel\RmString('Band');
        $this->String->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->String = new \ruhrpottmetaller\Data\LowLevel\RmString(null);
        $this->String->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testNewShouldAcceptStringAndGetShouldProvideItAgain(): void
    {
        $this->String = \ruhrpottmetaller\Data\LowLevel\RmString::new('Venue');
        $this->assertEquals('Venue', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(
            'City',
            RmString::new('Venue')->set('City')->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('VenueConcert');
        RmString::new('Venue')->print()->set('Concert')->print();
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->String = RmString::new('Venue')->set('Darkness');
        $this->assertEquals('Darkness', $this->String->get());
    }
}
