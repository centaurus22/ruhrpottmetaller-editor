<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\LowLevel\DataTypeBool;
use ruhrpottmetaller\Data\LowLevel\DataTypeDate;
use ruhrpottmetaller\Data\LowLevel\DataTypeInt;

final class FestivalTest extends TestCase
{
    private \ruhrpottmetaller\Data\HighLevel\AbstractEvent $DataSet;

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeInt
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
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     */
    public function testShouldThrowTypeErrorIfNoDataTypeIntIsSetToNumberOfDays(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Festival::new();
        $this->DataSet->setNumberOfDays(DataTypeBool::new(false));
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeDate
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
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     */
    public function testShouldThrowTypeErrorIfNoDataTypeDateIsSetToDateStart(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Festival::new();
        $this->DataSet->setDateStart(DataTypeBool::new(false));
    }

    /**
     * @covers \ruhrpottmetaller\HighLevel\QueryConcertDataSet
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeInt
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeDate
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
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
