<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\Concert;
use ruhrpottmetaller\Data\LowLevel\DataTypeBool;
use ruhrpottmetaller\Data\LowLevel\DataTypeDate;
use ruhrpottmetaller\Data\LowLevel\DataTypeInt;
use ruhrpottmetaller\Data\LowLevel\DataTypeString;

final class ConcertTest extends TestCase
{
    private Concert $DataSet;

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeDate
     */
    public function testShouldSetDateAndGetTheSameDate(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setDate(DataTypeDate::new('2922-11-01'));
        $this->assertEquals(
            '2922-11-01',
            $this->DataSet->getDate()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     */
    public function testShouldThrowTypeErrorIfNoDataTypeDateIsSetToDate(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setDate(DataTypeBool::new(false));
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeInt
     */
    public function testShouldSetIdAndGetTheSameId(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setId(DataTypeInt::new(23));
        $this->assertEquals(23, $this->DataSet->getId()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     */
    public function testShouldThrowTypeErrorIfNoDataTypeIntIsSetToId(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setId(DataTypeString::new('Iron Maiden'));
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     */
    public function testShouldSetNameAndGetTheSameName(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setName(DataTypeString::new('RockHard-Festival'));
        $this->assertEquals(
            'RockHard-Festival',
            $this->DataSet->getName()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeInt
     */
    public function testShouldThrowTypeErrorIfNoDataTypeStringIsSetToName(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setName(DataTypeInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     */
    public function testShouldSetVenueNameAndGetTheSameVenueName(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setVenueName(DataTypeString::new('Turock'));
        $this->assertEquals(
            'Turock',
            $this->DataSet->getVenueName()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeInt
     */
    public function testShouldThrowTypeErrorIfNoDataTypeStringIsSetToVenueName(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setVenueName(DataTypeInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     */
    public function testShouldSetCityNameAndGetTheSameCityName(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setCityName(DataTypeString::new('Essen'));
        $this->assertEquals(
            'Essen',
            $this->DataSet->getCityName()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeInt
     */
    public function testShouldThrowTypeErrorIfNoDataTypeStringIsSetToCityName(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setVenueName(DataTypeInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     */
    public function testShouldSetUrlAndGetTheSameUrl(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setUrl(DataTypeString::new('http://junkyard.ruhr/'));
        $this->assertEquals(
            'http://junkyard.ruhr/',
            $this->DataSet->getUrl()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeInt
     */
    public function testShouldThrowTypeErrorIfNoDataTypeStringIsSetToUrl(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setUrl(DataTypeInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     */
    public function testShouldSetSoldOutStatusAndGetTheSameSoldOutStatus(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setIsSoldOut(DataTypeBool::new(false));
        $this->assertEquals(false, $this->DataSet->getIsSoldOut()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeInt
     */
    public function testShouldThrowTypeErrorIfNoDataTypeBoolIsSetSoldOutStatus(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setIsSoldOut(DataTypeInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     */
    public function testShouldSetIsCanceledOutStatusAndGetTheSameIsCanceledStatus(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setIsCanceled(DataTypeBool::new(false));
        $this->assertEquals(false, $this->DataSet->getIsCanceled()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeInt
     */
    public function testShouldThrowTypeErrorIfNoDataTypeBoolIsSetToCanceledStatus(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setIsCanceled(DataTypeInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeInt
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeBool
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeDate
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     */
    public function testMethodsShouldBeChainable(): void
    {
        $this->DataSet = Concert::new()
            ->setId(DataTypeInt::new(3))
            ->setName(DataTypeString::new('Bierfest'))
            ->setDate(DataTypeDate::new('2022-07-07'))
            ->setVenueName(DataTypeString::new('Turock'))
            ->setCityName(DataTypeString::new('Essen'))
            ->setIsSoldOut(DataTypeBool::new(false))
            ->setIsCanceled(DataTypeBool::new(false))
            ->setUrl(DataTypeString::new('www.turock.eu'));
        $this->assertEquals(3, $this->DataSet->getId()->get());
        $this->assertEquals('Bierfest', $this->DataSet->getName()->get());
        $this->assertEquals('2022-07-07', $this->DataSet->getDate()->get());
        $this->assertEquals('Turock', $this->DataSet->getVenueName()->get());
        $this->assertEquals('Essen', $this->DataSet->getCityName()->get());
        $this->assertEquals(false, $this->DataSet->getIsSoldOut()->get());
        $this->assertEquals(false, $this->DataSet->getIsCanceled()->get());
        $this->assertEquals('www.turock.eu', $this->DataSet->getUrl()->get());
    }
}
