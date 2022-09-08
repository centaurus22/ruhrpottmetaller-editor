<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\Concert;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\RmBool;
use ruhrpottmetaller\Data\LowLevel\RmDate;
use ruhrpottmetaller\Data\LowLevel\RmInt;
use ruhrpottmetaller\Data\LowLevel\RmString;

final class ConcertTest extends TestCase
{
    private Concert $DataSet;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers  \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmDate
     */
    public function testShouldSetDateAndGetTheSameDate(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setDate(RmDate::new('2922-11-01'));
        $this->assertEquals(
            '2922-11-01',
            $this->DataSet->getDate()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmBool
     */
    public function testShouldThrowTypeErrorIfNoDataTypeDateIsSetToDate(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setDate(RmBool::new(false));
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmInt
     */
    public function testShouldSetIdAndGetTheSameId(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setId(RmInt::new(23));
        $this->assertEquals(23, $this->DataSet->getId()->get());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testShouldThrowTypeErrorIfNoDataTypeIntIsSetToId(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setId(RmString::new('Iron Maiden'));
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testShouldSetNameAndGetTheSameName(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setName(RmString::new('RockHard-Festival'));
        $this->assertEquals(
            'RockHard-Festival',
            $this->DataSet->getName()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmInt
     */
    public function testShouldThrowTypeErrorIfNoDataTypeStringIsSetToName(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setName(RmInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testShouldSetVenueAndGetTheSameVenue(): void
    {
        $Venue = Venue::new()->setName(RmString::new('Turock'));
        $this->DataSet = Concert::new();
        $this->DataSet->setVenue($Venue);
        $this->assertEquals(
            'Turock',
            $this->DataSet->getVenue()->getName()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmInt
     */
    public function testShouldThrowTypeErrorIfNoDataTypeStringIsSetToVenueName(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setVenue(RmInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testShouldSetUrlAndGetTheSameUrl(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setUrl(RmString::new('http://junkyard.ruhr/'));
        $this->assertEquals(
            'http://junkyard.ruhr/',
            $this->DataSet->getUrl()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmInt
     */
    public function testShouldThrowTypeErrorIfNoDataTypeStringIsSetToUrl(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setUrl(RmInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmBool
     */
    public function testShouldSetSoldOutStatusAndGetTheSameSoldOutStatus(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setIsSoldOut(RmBool::new(false));
        $this->assertEquals(false, $this->DataSet->getIsSoldOut()->get());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmInt
     */
    public function testShouldThrowTypeErrorIfNoDataTypeBoolIsSetSoldOutStatus(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setIsSoldOut(RmInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmBool
     */
    public function testShouldSetIsCanceledOutStatusAndGetTheSameIsCanceledStatus(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setIsCanceled(RmBool::new(false));
        $this->assertEquals(false, $this->DataSet->getIsCanceled()->get());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmInt
     */
    public function testShouldThrowTypeErrorIfNoDataTypeBoolIsSetToCanceledStatus(): void
    {
        $this->expectException(\TypeError::class);
        $this->DataSet = Concert::new();
        $this->DataSet->setIsCanceled(RmInt::new(3));
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testMethodsShouldBeChainable(): void
    {
        $Venue = Venue::new()->setName(RmString::new('Turock'));

        $this->DataSet = Concert::new()
            ->setId(RmInt::new(3))
            ->setName(RmString::new('Bierfest'))
            ->setDate(RmDate::new('2022-07-07'))
            ->setVenue($Venue)
            ->setIsSoldOut(RmBool::new(false))
            ->setIsCanceled(RmBool::new(false))
            ->setUrl(RmString::new('www.turock.eu'));
        $this->assertEquals(3, $this->DataSet->getId()->get());
        $this->assertEquals(
            'Bierfest',
            $this->DataSet->getName()->get()
        );
        $this->assertEquals(
            '2022-07-07',
            $this->DataSet->getDate()->get()
        );
        $this->assertEquals(
            'Turock',
            $this->DataSet->getVenue()->getName()->get()
        );
        $this->assertEquals(
            false,
            $this->DataSet->getIsSoldOut()->get()
        );
        $this->assertEquals(
            false,
            $this->DataSet->getIsCanceled()->get()
        );
        $this->assertEquals(
            'www.turock.eu',
            $this->DataSet->getUrl()->get()
        );
    }
}
