<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Variable;

use ruhrpottmetaller\Variable\VarString;
use PHPUnit\Framework\TestCase;

final class VarStringTest extends TestCase
{
    public \ruhrpottmetaller\Variable\IVarString $String;

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::get
     * @covers \ruhrpottmetaller\Variable\VarString::convertInput
     */
    public function testShoudReturnEmptyStringAfterAcceptingEmptyString(): void
    {
        $this->String = new \ruhrpottmetaller\Variable\VarString('');
        $this->assertEquals('', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::get
     * @covers \ruhrpottmetaller\Variable\VarString::convertInput
     */
    public function testShoudReturnSameStringAfterAcceptingString(): void
    {
        $this->String = new \ruhrpottmetaller\Variable\VarString('Festival');
        $this->assertEquals('Festival', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::get
     * @covers \ruhrpottmetaller\Variable\VarString::convertInput
     */
    public function testShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = new \ruhrpottmetaller\Variable\VarString(33);
        $this->assertEquals('33', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::get
     * @covers \ruhrpottmetaller\Variable\VarString::set
     * @covers \ruhrpottmetaller\Variable\VarString::convertInput
     */
    public function testGetItShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = new \ruhrpottmetaller\Variable\VarString('');
        $this->String->set(42);
        $this->assertEquals('42', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::get
     * @covers \ruhrpottmetaller\Variable\VarString::convertInput
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->String = new \ruhrpottmetaller\Variable\VarString(null);
        $this->assertTrue(is_null($this->String->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::get
     * @covers \ruhrpottmetaller\Variable\VarString::set
     * @covers \ruhrpottmetaller\Variable\VarString::convertInput
     */
    public function testShouldReturnNullAfterAcceptingNullBySetId(): void
    {
        $this->String = new \ruhrpottmetaller\Variable\VarString('');
        $this->String->set(null);
        $this->assertTrue(is_null($this->String->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::print
     * @covers \ruhrpottmetaller\Variable\VarString::convertInput
     */
    public function testShouldOutputStringAfterAccepting(): void
    {
        $this->expectOutputString('Band');
        $this->String = new \ruhrpottmetaller\Variable\VarString('Band');
        $this->String->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::print
     * @covers \ruhrpottmetaller\Variable\VarString::convertInput
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->String = new \ruhrpottmetaller\Variable\VarString(null);
        $this->String->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::convertInput
     * @covers \ruhrpottmetaller\Variable\VarString::new
     * @covers \ruhrpottmetaller\Variable\VarString::get
     */
    public function testNewShouldAcceptStringAndGetShouldProvideItAgain(): void
    {
        $this->String = \ruhrpottmetaller\Variable\VarString::new('Venue');
        $this->assertEquals('Venue', $this->String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::convertInput
     * @covers \ruhrpottmetaller\Variable\VarString::new
     * @covers \ruhrpottmetaller\Variable\VarString::get
     * @covers \ruhrpottmetaller\Variable\VarString::set
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(
            'City',
            VarString::new('Venue')->set('City')->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::convertInput
     * @covers \ruhrpottmetaller\Variable\VarString::new
     * @covers \ruhrpottmetaller\Variable\VarString::print
     * @covers \ruhrpottmetaller\Variable\VarString::set
     */
    public function testShoultPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('VenueConcert');
        VarString::new('Venue')->print()->set('Concert')->print();
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::convertInput
     * @covers \ruhrpottmetaller\Variable\VarString::new
     * @covers \ruhrpottmetaller\Variable\VarString::set
     * @covers \ruhrpottmetaller\Variable\VarString::get
     */
    public function testShoultGetTheValueFromTheLastChainedSet(): void
    {
        $this->String = VarString::new('Venue')->set('Darkness');
        $this->assertEquals('Darkness', $this->String->get());
    }
}
