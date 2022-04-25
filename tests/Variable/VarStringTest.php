<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Variable;

use PHPUnit\Framework\TestCase;

final class VarStringTest extends TestCase
{
    public \ruhrpottmetaller\Variable\IString $String;

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::getIt
     * @covers \ruhrpottmetaller\Variable\VarString::converInput
     */
    public function testShoudReturnEmptyStringAfterAcceptingEmptyString(): void
    {
        $this->String = new \ruhrpottmetaller\Variable\VarString('');
        $this->assertEquals('', $this->String->getIt());
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::getIt
     * @covers \ruhrpottmetaller\Variable\VarString::converInput
     */
    public function testShoudReturnSameStringAfterAcceptingString(): void
    {
        $this->String = new \ruhrpottmetaller\Variable\VarString('Festival');
        $this->assertEquals('Festival', $this->String->getIt());
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::getIt
     * @covers \ruhrpottmetaller\Variable\VarString::converInput
     */
    public function testShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = new \ruhrpottmetaller\Variable\VarString(33);
        $this->assertEquals('33', $this->String->getIt());
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::getIt
     * @covers \ruhrpottmetaller\Variable\VarString::setIt
     * @covers \ruhrpottmetaller\Variable\VarString::converInput
     */
    public function testGetItShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->String = new \ruhrpottmetaller\Variable\VarString('');
        $this->String->setIt(42);
        $this->assertEquals('42', $this->String->getIt());
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::getIt
     * @covers \ruhrpottmetaller\Variable\VarString::converInput
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->String = new \ruhrpottmetaller\Variable\VarString(null);
        $this->assertTrue(is_null($this->String->getIt()));
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::getIt
     * @covers \ruhrpottmetaller\Variable\VarString::setIt
     * @covers \ruhrpottmetaller\Variable\VarString::converInput
     */
    public function testShouldReturnNullAfterAcceptingNullBySetId(): void
    {
        $this->String = new \ruhrpottmetaller\Variable\VarString('');
        $this->String->setIt(null);
        $this->assertTrue(is_null($this->String->getIt()));
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::printIt
     * @covers \ruhrpottmetaller\Variable\VarString::converInput
     */
    public function testShouldOutputStringAfterAcceptingIt(): void
    {
        $this->expectOutputString('Band');
        $this->String = new \ruhrpottmetaller\Variable\VarString('Band');
        $this->String->PrintIt();
    }

    /**
     * @covers \ruhrpottmetaller\Variable\VarString::__construct
     * @covers \ruhrpottmetaller\Variable\VarString::printIt
     * @covers \ruhrpottmetaller\Variable\VarString::converInput
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->String = new \ruhrpottmetaller\Variable\VarString(null);
        $this->String->PrintIt();
    }
}
