<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\DataTypeBool;

final class DataTypeBoolTest extends TestCase
{
    private ?DataTypeBool $Bool = null;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldReturnTrueAfterAcceptingTrue(): void
    {
        $this->Bool = new DataTypeBool(true);
        $this->assertIsBool($this->Bool->get());
        $this->assertEquals(true, $this->Bool->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldReturnFalseAfterAcceptingFalse(): void
    {
        $this->Bool = new DataTypeBool(false);
        $this->assertIsBool($this->Bool->get());
        $this->assertEquals(false, $this->Bool->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldReturnStringAsTrue(): void
    {
        $this->Bool = new DataTypeBool('Beer');
        $this->assertIsBool($this->Bool->get());
        $this->assertEquals(true, $this->Bool->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldReturnBoolegegerLargerAsZerorAsTrue(): void
    {
        $this->Bool = new DataTypeBool(2);
        $this->assertIsBool($this->Bool->get());
        $this->assertEquals(true, $this->Bool->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testGetItShoudReturnFalseAfterAcceptingTrueAndThanSettingItToFalse(): void
    {
        $this->Bool = new DataTypeBool(true);
        $this->Bool->set(false);
        $this->assertEquals(false, $this->Bool->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->Bool = new DataTypeBool(null);
        $this->assertTrue(is_null($this->Bool->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldReturnNullAfterAcceptingNullBySet(): void
    {
        $this->Bool = new DataTypeBool(false);
        $this->Bool->set(null);
        $this->assertTrue(is_null($this->Bool->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldOutputNothingAfterAcceptingTrue(): void
    {
        $this->expectOutputString('1');
        $this->Bool = new DataTypeBool(true);
        $this->Bool->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldOutputNothingAfterAcceptingFalse(): void
    {
        $this->expectOutputString('');
        $this->Bool = new DataTypeBool(false);
        $this->Bool->Print();
    }
    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->Bool = new DataTypeBool(null);
        $this->Bool->Print();
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testNewShouldAcceptBoolAndGetShouldProvideItAgain(): void
    {
        $this->Bool = DataTypeBool::new(false);
        $this->assertIsBool($this->Bool->get());
        $this->assertEquals(false, $this->Bool->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(true, DataTypeBool::new(false)->set(true)->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('1');
        DataTypeBool::new(false)->print()->set(true)->print();
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->Int = DataTypeBool::new(false)->set(true);
        $this->assertEquals(true, $this->Int->get());
    }
}
