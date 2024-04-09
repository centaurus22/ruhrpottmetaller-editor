<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\RmArray;

final class RmArrayTest extends TestCase
{
    private RmArray $array;

    /**
     * @covers \ruhrpottmetaller\Data\RmArray
     */
    public function testShouldInitADataTypeArray(): void
    {
        $this->assertInstanceOf(RmArray::class, new RmArray());
    }

    /**
     * @covers \ruhrpottmetaller\Data\RmArray
     */
    public function testShouldImplementTheIDataTypeInterface(): void
    {
        $this->assertInstanceOf(IData::class, new RmArray());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     */
    public function testNewShouldInitADataTypeArray(): void
    {
        $this->assertInstanceOf(RmArray::class, RmArray::new());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @doesNotPerformAssertions
     */
    public function testAddShouldAcceptVariable(): void
    {
        $this->array = RmArray::new();
        $this->array->add(RmInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testGetShouldReturnSameVariable(): void
    {
        $this->array = RmArray::new();
        $this->array->add(RmInt::new(3));
        $this->assertEquals(3, $this->array->getCurrent()->get());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testAddShouldBeChainable(): void
    {
        $this->array = RmArray::new();
        $this->assertEquals(
            3,
            $this->array->add(RmInt::new(3))->getCurrent()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnTwoVariablesInTheSameOrderAsAdded(): void
    {
        $this->array = RmArray::new();
        $this->array->add(RmInt::new(5))->add(RmInt::new(7));
        $this->assertEquals(5, $this->array->getCurrent()->get());
        $this->assertEquals(
            7,
            $this->array->pointAtNext()->getCurrent()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     */
    public function testHasCurrentShouldReturnTrueIfElementIsAvailable(): void
    {
        $this->array = RmArray::new();
        $this->array->add(RmInt::new(5));
        $this->assertTrue($this->array->hasCurrent());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testHasCurrentShouldReturnFalseIfCurrentElementIsNotAvailable(): void
    {
        $this->array = RmArray::new();
        $this->assertFalse($this->array->hasCurrent());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testGetShouldThrowAnErrorIfCurrentElementIsNotAvailable(): void
    {
        $this->expectExceptionMessage('The Array does not contain data at this position.');
        $this->array = RmArray::new()->getCurrent();
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\RmArray
     * @uses  \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testGetShouldReturnTrueIfFirstElement(): void
    {
        $this->array = RmArray::new()->add('Decaptacon');
        $this->assertTrue($this->array->isFirst());
    }
}
