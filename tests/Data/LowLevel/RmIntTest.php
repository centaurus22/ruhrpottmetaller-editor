<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\RmInt;
use ruhrpottmetaller\Data\LowLevel\RmString;

final class RmIntTest extends TestCase
{
    /**
     * @var RmInt|\ruhrpottmetaller\Data\IDataObject
     */
    private $Int;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnSameIntAfterAcceptingInt(): void
    {
        $this->Int = new RmInt(2);
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(2, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnConvertibleStringAsIntegerAfterAcceptingString(): void
    {
        $this->Int = new RmInt('33');
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(33, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testGetItShouldReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->Int = new RmInt(42);
        $this->Int->set('42');
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(42, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->Int = new RmInt(null);
        $this->assertTrue(is_null($this->Int->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnNullAfterAcceptingNullBySetId(): void
    {
        $this->Int = new RmInt(3);
        $this->Int->set(null);
        $this->assertTrue(is_null($this->Int->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputStringAfterAcceptingIt(): void
    {
        $this->expectOutputString('23');
        $this->Int = new RmInt(23);
        echo $this->Int;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->Int = new RmInt(null);
        echo $this->Int;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testNewShouldAcceptIntAndGetShouldProvideItAgain(): void
    {
        $this->Int = RmInt::new(3);
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(3, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(13, RmInt::new(4)->set(13)->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('1337');
        echo RmInt::new(13)->set(1337);
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->Int = RmInt::new(12)->set(24);
        $this->assertEquals(24, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testShouldReturnStringObject(): void
    {
        $this->Int = RmInt::new(12);
        $this->assertInstanceOf(RmString::class, $this->Int->asString());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testShouldReturnStringObjectWhichContainTheIntAsString(): void
    {
        $this->Int = RmInt::new(12);
        $String = $this->Int->asString();
        $this->assertIsString($String->get());
        $this->assertEquals('12', $String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testShoultReturnStringObjectWhichContainTheIntAsString(): void
    {
        $this->Int = RmInt::new(12);
        $String = $this->Int->asString();
        $this->assertIsString($String->get());
        $this->assertEquals('12', $String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testAsStringShouldBeChainable(): void
    {
        $this->assertIsString(RmInt::new(12)->asString()->get());
        $this->assertEquals('12', RmInt::new(12)->asString()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testAsStringShouldBeChainableAndSavedToAVariable(): void
    {
        $String = RmInt::new(12)->set(3)->asString();
        $this->assertInstanceOf(RmString::class, $String);
    }
}
