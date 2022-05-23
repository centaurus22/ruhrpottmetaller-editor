<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\DataType;

use ruhrpottmetaller\DataType\DataTypeInt;
use ruhrpottmetaller\DataType\DataTypeString;
use ruhrpottmetaller\DataType\DataTypeBool;
use ruhrpottmetaller\DataType\DataTypeDate;
use ruhrpottmetaller\DataType\IDataType;
use ruhrpottmetaller\DataSet\QueryFestivalDataSet;
use PHPUnit\Framework\TestCase;

final class QueryFestivalDataSetTest extends TestCase
{
    /**
     * @covers \ruhrpottmetaller\DataSet\AbstractEventDataSet
     * @covers \ruhrpottmetaller\DataSet\AbstractFestivalDataSet
     * @covers \ruhrpottmetaller\DataSet\QueryFestivalDataSet
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeInt
     */
    public function testShouldSetNumberOfDaysAndGetTheSameNumberOfDays(): void
    {
        $this->DataSet = QueryFestivalDataSet::new();
        $this->DataSet->setNumberOfDays(DataTypeInt::new(23));
        $this->assertEquals(
            23,
            $this->DataSet->getNumberOfDays()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\DataSet\QueryFestivalDataSet
     * @covers \ruhrpottmetaller\DataSet\AbstractFestivalDataSet
     * @covers \ruhrpottmetaller\DataSet\AbstractEventDataSet
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeBool
     */
    public function testShouldThrowTypeErrorIfNoDataTypeIntIsSetToNumberOfDays(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = QueryFestivalDataSet::new();
        $this->DataSet->setNumberOfDays(DataTypeBool::new(false));
    }

    /**
     * @covers \ruhrpottmetaller\DataSet\AbstractEventDataSet
     * @covers \ruhrpottmetaller\DataSet\AbstractFestivalDataSet
     * @covers \ruhrpottmetaller\DataSet\QueryFestivalDataSet
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeDate
     */
    public function testShouldSetDateStartAndGetTheSameDateStart(): void
    {
        $this->DataSet = QueryFestivalDataSet::new();
        $this->DataSet->setDateStart(DataTypeDate::new('2922-11-01'));
        $this->assertEquals(
            '2922-11-01',
            $this->DataSet->getDateStart()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\DataSet\QueryFestivalDataSet
     * @covers \ruhrpottmetaller\DataSet\AbstractFestivalDataSet
     * @covers \ruhrpottmetaller\DataSet\AbstractEventDataSet
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\DataType\DataTypeBool
     */
    public function testShouldThrowTypeErrorIfNoDataTypeDateIsSetToDateStart(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = QueryFestivalDataSet::new();
        $this->DataSet->setDateStart(DataTypeBool::new(false));
    }


}
