<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\Int;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\Int\{AbstractRmInt, RmInt, RmNullInt};
use ruhrpottmetaller\Data\LowLevel\String\RmString;

final class RmIntTest extends TestCase
{
    private AbstractRmInt $value;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnSameIntAfterAcceptingInt(): void
    {
        $this->value = RmInt::new(2);
        $this->assertIsInt($this->value->get());
        $this->assertEquals(2, $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnConvertibleStringAsIntegerAfterAcceptingString(): void
    {
        $this->value = AbstractRmInt::new('33');
        $this->assertIsInt($this->value->get());
        $this->assertEquals(33, $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testGetItShouldReturnIntegerAsStringAfterAcceptingInteger(): void
    {
        $this->value = AbstractRmInt::new(42);
        $this->value->set('42');
        $this->assertIsInt($this->value->get());
        $this->assertEquals(42, $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->value = AbstractRmInt::new(null);
        $this->assertTrue(is_null($this->value->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnNullAfterAcceptingNullBySetId(): void
    {
        $this->value = AbstractRmInt::new(3)->set(null);
        $this->assertInstanceOf(RmNullInt::class, $this->value);
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldOutputStringAfterAcceptingIt(): void
    {
        $this->expectOutputString('23');
        $this->value = AbstractRmInt::new(23);
        echo $this->value;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->value = AbstractRmInt::new(null);
        echo $this->value;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testNewShouldAcceptIntAndGetShouldProvideItAgain(): void
    {
        $this->value = RmInt::new(3);
        $this->assertIsInt($this->value->get());
        $this->assertEquals(3, $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(13, RmInt::new(4)->set(13)->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('1337');
        echo RmInt::new(13)->set(1337);
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->value = RmInt::new(12)->set(24);
        $this->assertEquals(24, $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldReturnStringObject(): void
    {
        $this->value = RmInt::new(12);
        $this->assertInstanceOf(RmString::class, $this->value->asString());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldReturnStringObjectWhichContainTheIntAsString(): void
    {
        $this->value = RmInt::new(12);
        $String = $this->value->asString();
        $this->assertIsString($String->get());
        $this->assertEquals('12', $String->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
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
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
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
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */
    public function testIsNullShouldReturnTrue(): void
    {
        $this->value = RmInt::new(null);
        $this->assertEquals(true, $this->value->isNull());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @covers \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldReturnAHiddenInputField(): void
    {
        $this->value = RmInt::new(23);
        $expectedString = '<input type="hidden" name="id" value="23">';
        $this->assertEquals(
            $expectedString,
            $this->value->asHiddenInput(RmString::new('id'))
        );
    }
}
