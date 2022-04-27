<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Datatype;

use ruhrpottmetaller\Datatype\DatatypeString;
use PHPUnit\Framework\TestCase;

final class VarStringTest extends TestCase
{
    public \ruhrpottmetaller\Datatype\DatatypeString $String;

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     */
    public function testShoudReturnEmptyStringAfterAcceptingEmptyString(): void
    {
        $this->String = new \ruhrpottmetaller\Datatype\DatatypeString('');
        $this->assertEquals('', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     */
    public function testShoudReturnSameStringAfterAcceptingString(): void
    {
        $this->String = new \ruhrpottmetaller\Datatype\DatatypeString('Festival');
        $this->assertEquals('Festival', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     */
    public function testShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = new \ruhrpottmetaller\Datatype\DatatypeString(33);
        $this->assertEquals('33', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::set
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     */
    public function testGetItShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = new \ruhrpottmetaller\Datatype\DatatypeString('');
        $this->String->set(42);
        $this->assertEquals('42', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->String = new \ruhrpottmetaller\Datatype\DatatypeString(null);
        $this->assertTrue(is_null($this->String->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::set
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     */
    public function testShouldReturnNullAfterAcceptingNullBySetId(): void
    {
        $this->String = new \ruhrpottmetaller\Datatype\DatatypeString('');
        $this->String->set(null);
        $this->assertTrue(is_null($this->String->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::print
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     */
    public function testShouldOutputStringAfterAccepting(): void
    {
        $this->expectOutputString('Band');
        $this->String = new \ruhrpottmetaller\Datatype\DatatypeString('Band');
        $this->String->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::print
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->String = new \ruhrpottmetaller\Datatype\DatatypeString(null);
        $this->String->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::new
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::get
     */
    public function testNewShouldAcceptStringAndGetShouldProvideItAgain(): void
    {
        $this->String = \ruhrpottmetaller\Datatype\DatatypeString::new('Venue');
        $this->assertEquals('Venue', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::new
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::set
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(
            'City',
            DatatypeString::new('Venue')->set('City')->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::new
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::print
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::set
     */
    public function testShoultPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('VenueConcert');
        DatatypeString::new('Venue')->print()->set('Concert')->print();
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::new
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::set
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::get
     */
    public function testShoultGetTheValueFromTheLastChainedSet(): void
    {
        $this->String = DatatypeString::new('Venue')->set('Darkness');
        $this->assertEquals('Darkness', $this->String->get());
    }
}
