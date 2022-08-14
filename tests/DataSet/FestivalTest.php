<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\DataSet;

use ruhrpottmetaller\DataType\DataTypeInt;
use ruhrpottmetaller\DataType\DataTypeBool;
use ruhrpottmetaller\DataType\DataTypeDate;
use ruhrpottmetaller\Data\Festival;
use PHPUnit\Framework\TestCase;

final class FestivalTest extends TestCase
{
    private \ruhrpottmetaller\Data\AbstractEvent $DataSet;

    /**
     * @covers \ruhrpottmetaller\Data\AbstractEvent
     * @covers \ruhrpottmetaller\Data\Festival
     * @covers \ruhrpottmetaller\Data\Festival
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     */
    public function testShouldSetNumberOfDaysAndGetTheSameNumberOfDays(): void
    {
        $this->DataSet = Festival::new();
        $this->DataSet->setNumberOfDays(DataTypeInt::new(23));
        $this->assertEquals(
            23,
            $this->DataSet->getNumberOfDays()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\Festival
     * @covers \ruhrpottmetaller\Data\Festival
     * @covers \ruhrpottmetaller\Data\AbstractEvent
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeBool
     */
    public function testShouldThrowTypeErrorIfNoDataTypeIntIsSetToNumberOfDays(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Festival::new();
        $this->DataSet->setNumberOfDays(DataTypeBool::new(false));
    }

    /**
     * @covers \ruhrpottmetaller\Data\AbstractEvent
     * @covers \ruhrpottmetaller\Data\Festival
     * @covers \ruhrpottmetaller\Data\Festival
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeDate
     */
    public function testShouldSetDateStartAndGetTheSameDateStart(): void
    {
        $this->DataSet = Festival::new();
        $this->DataSet->setDateStart(DataTypeDate::new('2922-11-01'));
        $this->assertEquals(
            '2922-11-01',
            $this->DataSet->getDateStart()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\Festival
     * @covers \ruhrpottmetaller\Data\Festival
     * @covers \ruhrpottmetaller\Data\AbstractEvent
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeBool
     */
    public function testShouldThrowTypeErrorIfNoDataTypeDateIsSetToDateStart(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Festival::new();
        $this->DataSet->setDateStart(DataTypeBool::new(false));
    }

    /**
     * @covers \ruhrpottmetaller\Data\QueryConcertDataSet
     * @covers \ruhrpottmetaller\Data\AbstractEvent
     * @covers \ruhrpottmetaller\Data\Festival
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     * @covers \ruhrpottmetaller\DataType\DataTypeBool
     * @covers \ruhrpottmetaller\DataType\DataTypeDate
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     */
    public function testMethodsShouldBeChainable(): void
    {
        $this->DataSet = Festival::new()
            ->setDateStart(DataTypeDate::new('2022-07-07'))
            ->setNumberOfDays(DataTypeInt::new(4));
        $this->assertEquals('2022-07-07', $this->DataSet->getDateStart()->get());
        $this->assertEquals(4, $this->DataSet->getNumberOfDays()->get());
    }
}
