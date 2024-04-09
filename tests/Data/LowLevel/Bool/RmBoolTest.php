<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel\Bool;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\Bool\{AbstractRmBool, RmBool};
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

final class RmBoolTest extends TestCase
{
    private AbstractRmBool $value;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnTrueAfterAcceptingTrue(): void
    {
        $this->value = RmBool::new(true);
        $this->assertIsBool($this->value->get());
        $this->assertEquals(true, $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnFalseAfterAcceptingFalse(): void
    {
        $this->value = RmBool::new(false);
        $this->assertIsBool($this->value->get());
        $this->assertEquals(false, $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnStringAsTrue(): void
    {
        $this->value = RmBool::new('Beer');
        $this->assertIsBool($this->value->get());
        $this->assertEquals(true, $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldConvertValueLargerThanZeroAsTrue(): void
    {
        $this->value = RmBool::new(2);
        $this->assertIsBool($this->value->get());
        $this->assertEquals(true, $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmFalse
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testGetItShouldReturnFalseAfterAcceptingTrueAndThanSettingItToFalse(): void
    {
        $this->value = RmBool::new(true)->set(false);
        $this->assertEquals(true, $this->value->isFalse());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->value = RmBool::new(null);
        $this->assertTrue(is_null($this->value->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnNullAfterAcceptingNullBySet(): void
    {
        $this->value = RmBool::new(false)->set(null);
        $this->assertTrue(is_null($this->value->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldOutputNothingAfterAcceptingTrue(): void
    {
        $this->expectOutputString('1');
        $this->value = RmBool::new(true);
        echo $this->value;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldOutputNothingAfterAcceptingFalse(): void
    {
        $this->expectOutputString('');
        $this->value = RmBool::new(false);
        echo $this->value;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->value = RmBool::new(null);
        echo $this->value;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testNewShouldAcceptBoolAndGetShouldProvideItAgain(): void
    {
        $this->value = RmBool::new(false);
        $this->assertIsBool($this->value->get());
        $this->assertEquals(false, $this->value->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(true, RmBool::new(false)->set(true)->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('1');
        echo RmBool::new(false)->set(true);
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->value = RmBool::new(false)->set(true);
        $this->assertEquals(true, $this->value->get());
    }
}
