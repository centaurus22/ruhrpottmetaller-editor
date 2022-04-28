<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Datatype;

use ruhrpottmetaller\Datatype\DatatypeInt;
use ruhrpottmetaller\Datatype\DatatypeString;
use PHPUnit\Framework\TestCase;

final class DatatypeIntTest extends TestCase
{
    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     */
    public function testShouldReturnSameIntAfterAcceptingInt(): void
    {
        $this->Int = new DatatypeInt(2);
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(2, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     */
    public function testShouldReturnConvertibleStringAsIntegerAfterAcceptingString(): void
    {
        $this->Int = new DatatypeInt('33');
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(33, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::set
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     */
    public function testGetItShoudReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->Int = new DatatypeInt(42);
        $this->Int->set('42');
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(42, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->Int = new DatatypeInt(null);
        $this->assertTrue(is_null($this->Int->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::set
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     */
    public function testShouldReturnNullAfterAcceptingNullBySetId(): void
    {
        $this->Int = new DatatypeInt(3);
        $this->Int->set(null);
        $this->assertTrue(is_null($this->Int->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::print
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     */
    public function testShouldOutputStringAfterAcceptingIt(): void
    {
        $this->expectOutputString('23');
        $this->Int = new DatatypeInt(23);
        $this->Int->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::print
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->Int = new DatatypeInt(null);
        $this->Int->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::new
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::get
     */
    public function testNewShouldAcceptIntAndGetShouldProvideItAgain(): void
    {
        $this->Int = DatatypeInt::new(3);
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(3, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::new
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::set
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(13, DatatypeInt::new(4)->set(13)->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::new
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::print
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::set
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('1337');
        DatatypeInt::new(13)->print()->set(37)->print();
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::new
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::set
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::get
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->Int = DatatypeInt::new(12)->set(24);
        $this->assertEquals(24, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::new
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::asString
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     */
    public function testShouldReturnStringObject(): void
    {
        $this->Int = DatatypeInt::new(12);
        $this->assertInstanceOf(DatatypeString::class, $this->Int->asString());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::new
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::asString
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     */
    public function testShouldReturnStringObjectWhichContainTheIntAsString(): void
    {
        $this->Int = DatatypeInt::new(12);
        $String = $this->Int->asString();
        $this->assertIsString($String->get());
        $this->assertEquals('12', $String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::new
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::asString
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     */
    public function testShoultReturnStringObjectWhichContainTheIntAsString(): void
    {
        $this->Int = DatatypeInt::new(12);
        $String = $this->Int->asString();
        $this->assertIsString($String->get());
        $this->assertEquals('12', $String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::new
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::asString
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     */
    public function testAsStringShouldBeChainable(): void
    {
        $this->assertIsString(DatatypeInt::new(12)->asString()->get());
        $this->assertEquals('12', DatatypeInt::new(12)->asString()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::__construct
     * @covers \ruhrpottmetaller\Datatype\AbstractDatatypeValue::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::convertInput
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::new
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::set
     * @covers \ruhrpottmetaller\Datatype\DatatypeInt::asString
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::get
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::__construct
     * @covers \ruhrpottmetaller\Datatype\DatatypeString::convertInput
     */
    public function testAsStringShouldBeChainableAndSavedToAVariable(): void
    {
        $String = DatatypeInt::new(12)->set(3)->asString();
        $this->assertInstanceOf(DatatypeString::class, $String);
    }
}
