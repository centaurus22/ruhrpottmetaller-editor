<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\{Band, City, Concert, Venue, Gig};
use ruhrpottmetaller\Data\LowLevel\{Bool\RmBool, Date\RmDate, Int\RmInt, String\RmString};
use ruhrpottmetaller\Data\RmArray;

final class ConcertTest extends TestCase
{
    private Concert $dataSet;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers  \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     */
    public function testShouldSetDateAndGetTheSameDate(): void
    {
        $this->dataSet = Concert::new();
        $this->dataSet->setDate(RmDate::new('2922-11-01'));
        $this->assertEquals(
            '2922-11-01',
            $this->dataSet->getDate()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     */
    public function testShouldSetIdAndGetTheSameId(): void
    {
        $this->dataSet = Concert::new();
        $this->dataSet->setId(RmInt::new(23));
        $this->assertEquals(23, $this->dataSet->getId()->get());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldSetNameAndGetTheSameName(): void
    {
        $this->dataSet = Concert::new();
        $this->dataSet->setName(RmString::new('RockHard-Festival'));
        $this->assertEquals(
            'RockHard-Festival',
            $this->dataSet->getName()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldSetUrlAndGetTheSameUrl(): void
    {
        $this->dataSet = Concert::new();
        $this->dataSet->setUrl(RmString::new('https://junkyard.ruhr/'));
        $this->assertEquals(
            'https://junkyard.ruhr/',
            $this->dataSet->getUrl()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     */
    public function testShouldSetSoldOutStatusAndGetTheSameSoldOutStatus(): void
    {
        $this->dataSet = Concert::new();
        $this->dataSet->setIsSoldOut(RmBool::new(false));
        $this->assertEquals(false, $this->dataSet->getIsSoldOut()->get());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     */
    public function testShouldSetIsCanceledOutStatusAndGetTheSameIsCanceledStatus(): void
    {
        $this->dataSet = Concert::new();
        $this->dataSet->setIsCanceled(RmBool::new(false));
        $this->assertEquals(false, $this->dataSet->getIsCanceled()->get());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testMethodsShouldBeChainable(): void
    {
        $Venue = Venue::new()->setName(RmString::new('Turock'));

        $this->dataSet = Concert::new()
            ->setId(RmInt::new(3))
            ->setName(RmString::new('Bierfest'))
            ->setDate(RmDate::new('2022-07-07'))
            ->setVenue($Venue)
            ->setIsSoldOut(RmBool::new(false))
            ->setIsCanceled(RmBool::new(false))
            ->setUrl(RmString::new('www.turock.eu'));
        $this->assertEquals(3, $this->dataSet->getId()->get());
        $this->assertEquals(
            'Bierfest',
            $this->dataSet->getName()->get()
        );
        $this->assertEquals(
            '2022-07-07',
            $this->dataSet->getDate()->get()
        );
        $this->assertEquals(
            false,
            $this->dataSet->getIsSoldOut()->get()
        );
        $this->assertEquals(
            false,
            $this->dataSet->getIsCanceled()->get()
        );
        $this->assertEquals(
            'www.turock.eu',
            $this->dataSet->getUrl()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers  \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */
    public function testShouldGetFormattedDate(): void
    {
        $this->dataSet = Concert::new();
        $this->dataSet->setDate(RmDate::new('2022-10-22'));
        $this->assertEquals(
            'Sat, 22.',
            $this->dataSet->getFormattedDate()->get()
        );
    }

    /**
    * @covers \ruhrpottmetaller\AbstractRmObject
    * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
    * @covers \ruhrpottmetaller\Data\HighLevel\Concert
    * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
    * @covers \ruhrpottmetaller\Data\HighLevel\Venue
    * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
    * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
    * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
    * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
    * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
    * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
    * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
    * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
    * @uses   \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
    */
    public function testMethodsShouldGetCombinedVenueAndCityName(): void
    {
        $City = City::new()->setName(RmString::new('Essen'));
        $Venue = Venue::new()
            ->setName(RmString::new('Turock'))
            ->setCity($City);

        $this->dataSet = Concert::new()
        ->setId(RmInt::new(3))
        ->setName(RmString::new('Bierfest'))
        ->setDate(RmDate::new('2022-07-07'))
        ->setVenue($Venue)
        ->setIsSoldOut(RmBool::new(false))
        ->setIsCanceled(RmBool::new(false))
        ->setUrl(RmString::new('www.turock.eu'));
        $this->assertEquals(
            'Turock, Essen',
            $this->dataSet->getVenueAndCityName()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\Gig
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */
    public function testMethodsShouldGetBandList(): void
    {
        $gigs = RmArray::new()
            ->add(Gig::new()->setBand(Band::new()->setName(RmString::new('Dipsomania'))));
        $this->dataSet = Concert::new()
            ->addGigs($gigs);
        $this->assertEquals('Dipsomania', $this->dataSet->getBandList());
    }
}
