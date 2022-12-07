<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\Int;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\Int\RmNullInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

final class RmIntTest extends TestCase
{
    private $Int;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnSameIntAfterAcceptingInt(): void
    {
        $this->Int = RmInt::new(2);
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(2, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnConvertibleStringAsIntegerAfterAcceptingString(): void
    {
        $this->Int = AbstractRmInt::new('33');
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(33, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testGetItShouldReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->Int = AbstractRmInt::new(42);
        $this->Int->set('42');
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(42, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->Int = AbstractRmInt::new(null);
        $this->assertTrue(is_null($this->Int->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnNullAfterAcceptingNullBySetId(): void
    {
        $this->Int = AbstractRmInt::new(3)->set(null);
        $this->assertInstanceOf(RmNullInt::class, $this->Int);
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputStringAfterAcceptingIt(): void
    {
        $this->expectOutputString('23');
        $this->Int = AbstractRmInt::new(23);
        echo $this->Int;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->Int = AbstractRmInt::new(null);
        echo $this->Int;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testNewShouldAcceptIntAndGetShouldProvideItAgain(): void
    {
        $this->Int = RmInt::new(3);
        $this->assertIsInt($this->Int->get());
        $this->assertEquals(3, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(13, RmInt::new(4)->set(13)->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('1337');
        echo RmInt::new(13)->set(1337);
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->Int = RmInt::new(12)->set(24);
        $this->assertEquals(24, $this->Int->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldReturnStringObject(): void
    {
        $this->Int = RmInt::new(12);
        $this->assertInstanceOf(RmString::class, $this->Int->asString());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldReturnStringObjectWhichContainTheIntAsString(): void
    {
        $this->Int = RmInt::new(12);
        $String = $this->Int->asString();
        $this->assertIsString($String->get());
        $this->assertEquals('12', $String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testAsStringShouldBeChainable(): void
    {
        $this->assertIsString(RmInt::new(12)->asString()->get());
        $this->assertEquals('12', RmInt::new(12)->asString()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testAsStringShouldBeChainableAndSavedToAVariable(): void
    {
        $String = RmInt::new(12)->set(3)->asString();
        $this->assertInstanceOf(RmString::class, $String);
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */
    public function testIsNullShouldReturnTrue(): void
    {
        $this->Int = RmInt::new(null);
        $this->assertEquals(true, $this->Int->isNull());
    }
}
