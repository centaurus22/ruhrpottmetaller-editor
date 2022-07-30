<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\DataType;

use ruhrpottmetaller\DataType\DataTypeArray;
use ruhrpottmetaller\DataType\DataTypeInt;
use ruhrpottmetaller\DataType\IDataType;
use PHPUnit\Framework\TestCase;

final class DataTypeArrayTest extends TestCase
{
    private DataTypeArray $Array;

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeArray
     */
    public function testShouldInitADataTypeArray(): void
    {
        $this->assertInstanceOf(DataTypeArray::class, new DataTypeArray());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeArray
     */
    public function testShouldImplementTheIDataTypeInterface(): void
    {
        $this->assertInstanceOf(IDataType::class, new DataTypeArray());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeArray
     */
    public function testNewShouldInitADataTypeArray(): void
    {
        $this->assertInstanceOf(DataTypeArray::class, DataTypeArray::new());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeArray
     * @doesNotPerformAssertions
     */
    public function testAddShouldAcceptVariable(): void
    {
        $this->Array = DataTypeArray::new();
        $this->Array->add(DataTypeInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeArray
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testGetShouldReturnSameVariable(): void
    {
        $this->Array = DataTypeArray::new();
        $this->Array->add(DataTypeInt::new(3));
        $this->assertEquals(3, $this->Array->getCurrent()->get());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeArray
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testAddShouldBeChainable(): void
    {
        $this->Array = DataTypeArray::new();
        $this->assertEquals(
            3,
            $this->Array->add(DataTypeInt::new(3))->getCurrent()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeArray
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testShouldReturnTwoVariablesInTheSameOrderAsAdded(): void
    {
        $this->Array = DataTypeArray::new();
        $this->Array->add(DataTypeInt::new(5))->add(DataTypeInt::new(7));
        $this->assertEquals(5, $this->Array->getCurrent()->get());
        $this->assertEquals(
            7,
            $this->Array->pointAtNext()->getCurrent()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeArray
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testHasCurrentShouldReturnTrueIfElementIsAvailable(): void
    {
        $this->Array = DataTypeArray::new();
        $this->Array->add(DataTypeInt::new(5));
        $this->assertTrue($this->Array->hasCurrent());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeArray
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testHasCurrentShouldReturnFalseIfCurrentElementIsNotAvailable(): void
    {
        $this->Array = DataTypeArray::new();
        $this->assertFalse($this->Array->hasCurrent());
    }

    /**
     * @covers \ruhrpottmetaller\DataType\DataTypeArray
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     */
    public function testGetShouldThrowAnErrorIfCurrentElementIsNotAvailable(): void
    {
        $this->expectExceptionMessage('The Array does not contain data at this position.');
        $this->Array = DataTypeArray::new()->getCurrent();
    }
}
