<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Datatype;

use ruhrpottmetaller\Datatype\DatatypeInt;
use PHPUnit\Framework\TestCase;

final class DatatypeIntTest extends TestCase
{
    /**
     * @covers DatatypeInt::__construct
     * @covers DatatypeInt::get
     * @covers DatatypeInt::convertInput
     */
    public function testShouldReturnSameIntAfterAcceptingInt(): void
    {
        $this->Int = new DatatypeInt(2);
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(2, $this->Int->get());
    }

    /**
     * @covers DatatypeInt::__construct
     * @covers DatatypeInt::get
     * @covers DatatypeInt::convertInput
     */
    public function testShouldReturnConvertibleStringAsIntegerAfterAcceptingString(): void
    {
        $this->Int = new DatatypeInt('33');
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(33, $this->Int->get());
    }

    /**
     * @covers DatatypeInt::__construct
     * @covers DatatypeInt::get
     * @covers DatatypeInt::set
     * @covers DatatypeInt::convertInput
     */
    public function testGetItShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->Int = new DatatypeInt(42);
        $this->Int->set('42');
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(42, $this->Int->get());
    }

    /**
     * @covers DatatypeInt::__construct
     * @covers DatatypeInt::get
     * @covers DatatypeInt::convertInput
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->Int = new DatatypeInt(null);
        $this->assertTrue(is_null($this->Int->get()));
    }

    /**
     * @covers DatatypeInt::__construct
     * @covers DatatypeInt::get
     * @covers DatatypeInt::set
     * @covers DatatypeInt::convertInput
     */
    public function testShouldReturnNullAfterAcceptingNullBySetId(): void
    {
        $this->Int = new DatatypeInt(3);
        $this->Int->set(null);
        $this->assertTrue(is_null($this->Int->get()));
    }

    /**
     * @covers DatatypeInt::__construct
     * @covers DatatypeInt::print
     * @covers DatatypeInt::convertInput
     */
    public function testShouldOutputStringAfterAcceptingIt(): void
    {
        $this->expectOutputString('23');
        $this->Int = new DatatypeInt(23);
        $this->Int->Print();
    }

    /**
     * @covers DatatypeInt::__construct
     * @covers DatatypeInt::print
     * @covers DatatypeInt::convertInput
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->Int = new DatatypeInt(null);
        $this->Int->Print();
    }

    /**
     * @covers DatatypeInt::__construct
     * @covers DatatypeInt::convertInput
     * @covers DatatypeInt::new
     * @covers DatatypeInt::get
     */
    public function testNewShouldAcceptIntAndGetShouldProvideItAgain(): void
    {
        $this->Int = DatatypeInt::new(3);
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(3, $this->Int->get());
    }

    /**
     * @covers DatatypeInt::__construct
     * @covers DatatypeInt::convertInput
     * @covers DatatypeInt::new
     * @covers DatatypeInt::get
     * @covers DatatypeInt::set
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(13, DatatypeInt::new(4)->set(13)->get());
    }

    /**
     * @covers DatatypeInt::__construct
     * @covers DatatypeInt::convertInput
     * @covers DatatypeInt::new
     * @covers DatatypeInt::print
     * @covers DatatypeInt::set
     */
    public function testShoultPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('1337');
        DatatypeInt::new(13)->print()->set(37)->print();
    }

    /**
     * @covers DatatypeInt::__construct
     * @covers DatatypeInt::convertInput
     * @covers DatatypeInt::new
     * @covers DatatypeInt::set
     * @covers DatatypeInt::get
     */
    public function testShoultGetTheValueFromTheLastChainedSet(): void
    {
        $this->Int = DatatypeInt::new(12)->set(24);
        $this->assertEquals(24, $this->Int->get());
    }
}
