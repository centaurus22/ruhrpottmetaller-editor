<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\LowLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\RmArray;
use ruhrpottmetaller\Data\LowLevel\RmInt;
use ruhrpottmetaller\Data\LowLevel\IRmValue;

final class RmArrayTest extends TestCase
{
    private RmArray $Array;

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     */
    public function testShouldInitADataTypeArray(): void
    {
        $this->assertInstanceOf(RmArray::class, new RmArray());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     */
    public function testShouldImplementTheIDataTypeInterface(): void
    {
        $this->assertInstanceOf(IRmValue::class, new RmArray());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     */
    public function testNewShouldInitADataTypeArray(): void
    {
        $this->assertInstanceOf(RmArray::class, RmArray::new());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @doesNotPerformAssertions
     */
    public function testAddShouldAcceptVariable(): void
    {
        $this->Array = RmArray::new();
        $this->Array->add(RmInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     */
    public function testGetShouldReturnSameVariable(): void
    {
        $this->Array = RmArray::new();
        $this->Array->add(RmInt::new(3));
        $this->assertEquals(3, $this->Array->getCurrent()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     */
    public function testAddShouldBeChainable(): void
    {
        $this->Array = RmArray::new();
        $this->assertEquals(
            3,
            $this->Array->add(RmInt::new(3))->getCurrent()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     */
    public function testShouldReturnTwoVariablesInTheSameOrderAsAdded(): void
    {
        $this->Array = RmArray::new();
        $this->Array->add(RmInt::new(5))->add(RmInt::new(7));
        $this->assertEquals(5, $this->Array->getCurrent()->get());
        $this->assertEquals(
            7,
            $this->Array->pointAtNext()->getCurrent()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     */
    public function testHasCurrentShouldReturnTrueIfElementIsAvailable(): void
    {
        $this->Array = RmArray::new();
        $this->Array->add(RmInt::new(5));
        $this->assertTrue($this->Array->hasCurrent());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     */
    public function testHasCurrentShouldReturnFalseIfCurrentElementIsNotAvailable(): void
    {
        $this->Array = RmArray::new();
        $this->assertFalse($this->Array->hasCurrent());
    }

    /**
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     */
    public function testGetShouldThrowAnErrorIfCurrentElementIsNotAvailable(): void
    {
        $this->expectExceptionMessage('The Array does not contain data at this position.');
        $this->Array = RmArray::new()->getCurrent();
    }
}
