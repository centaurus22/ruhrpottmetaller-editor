<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\RmBool;

final class RmBoolTest extends TestCase
{
    private ?RmBool $Bool = null;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnTrueAfterAcceptingTrue(): void
    {
        $this->Bool = new RmBool(true);
        $this->assertIsBool($this->Bool->get());
        $this->assertEquals(true, $this->Bool->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnFalseAfterAcceptingFalse(): void
    {
        $this->Bool = new RmBool(false);
        $this->assertIsBool($this->Bool->get());
        $this->assertEquals(false, $this->Bool->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnStringAsTrue(): void
    {
        $this->Bool = new RmBool('Beer');
        $this->assertIsBool($this->Bool->get());
        $this->assertEquals(true, $this->Bool->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnBoolegegerLargerAsZerorAsTrue(): void
    {
        $this->Bool = new RmBool(2);
        $this->assertIsBool($this->Bool->get());
        $this->assertEquals(true, $this->Bool->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testGetItShouldReturnFalseAfterAcceptingTrueAndThanSettingItToFalse(): void
    {
        $this->Bool = new RmBool(true);
        $this->Bool->set(false);
        $this->assertEquals(false, $this->Bool->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnNullAfterAcceptingNull(): void
    {
        $this->Bool = new RmBool(null);
        $this->assertTrue(is_null($this->Bool->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnNullAfterAcceptingNullBySet(): void
    {
        $this->Bool = new RmBool(false);
        $this->Bool->set(null);
        $this->assertTrue(is_null($this->Bool->get()));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputNothingAfterAcceptingTrue(): void
    {
        $this->expectOutputString('1');
        $this->Bool = new RmBool(true);
        echo $this->Bool;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputNothingAfterAcceptingFalse(): void
    {
        $this->expectOutputString('');
        $this->Bool = new RmBool(false);
        echo $this->Bool;
    }
    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldOutputEmptyStringAfterAcceptingNull(): void
    {
        $this->expectOutputString('');
        $this->Bool = new RmBool(null);
        echo $this->Bool;
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testNewShouldAcceptBoolAndGetShouldProvideItAgain(): void
    {
        $this->Bool = RmBool::new(false);
        $this->assertIsBool($this->Bool->get());
        $this->assertEquals(false, $this->Bool->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testGetShouldReturnLastChainedSet(): void
    {
        $this->assertEquals(true, RmBool::new(false)->set(true)->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldPrintTheValueFromTheLastChainedSet(): void
    {
        $this->expectOutputString('1');
        echo RmBool::new(false)->set(true);
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldGetTheValueFromTheLastChainedSet(): void
    {
        $this->Int = RmBool::new(false)->set(true);
        $this->assertEquals(true, $this->Int->get());
    }
}
