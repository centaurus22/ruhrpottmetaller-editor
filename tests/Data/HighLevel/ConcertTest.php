<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\{Band, City, Concert, Venue};
use ruhrpottmetaller\Data\LowLevel\{Bool\RmBool, Date\RmDate, Int\RmInt, String\RmString};

final class ConcertTest extends TestCase
{
    private Concert $DataSet;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers  \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
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
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     */
    public function testShouldSetIdAndGetTheSameId(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setId(RmInt::new(23));
        $this->assertEquals(23, $this->DataSet->getId()->get());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
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
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldSetUrlAndGetTheSameUrl(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setUrl(RmString::new('https://junkyard.ruhr/'));
        $this->assertEquals(
            'https://junkyard.ruhr/',
            $this->DataSet->getUrl()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     */
    public function testShouldSetSoldOutStatusAndGetTheSameSoldOutStatus(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setIsSoldOut(RmBool::new(false));
        $this->assertEquals(false, $this->DataSet->getIsSoldOut()->get());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     */
    public function testShouldSetIsCanceledOutStatusAndGetTheSameIsCanceledStatus(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setIsCanceled(RmBool::new(false));
        $this->assertEquals(false, $this->DataSet->getIsCanceled()->get());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
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

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers  \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */
    public function testShouldGetFormattedDate(): void
    {
        $this->DataSet = Concert::new();
        $this->DataSet->setDate(RmDate::new('2022-10-22'));
        $this->assertEquals(
            'Sat, 22.',
            $this->DataSet->getFormattedDate()->get()
        );
    }

    /**
    * @covers \ruhrpottmetaller\AbstractRmObject
    * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
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

        $this->DataSet = Concert::new()
        ->setId(RmInt::new(3))
        ->setName(RmString::new('Bierfest'))
        ->setDate(RmDate::new('2022-07-07'))
        ->setVenue($Venue)
        ->setIsSoldOut(RmBool::new(false))
        ->setIsCanceled(RmBool::new(false))
        ->setUrl(RmString::new('www.turock.eu'));
        $this->assertEquals(
            'Turock, Essen',
            $this->DataSet->getVenueAndCityName()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\RmArray
     */
    public function testMethodsShouldGetEmptyBandArray(): void
    {
        $this->DataSet = Concert::new();
        $this->assertEquals(
            false,
            $this->DataSet->hasCurrentBand()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\RmArray
     */
    public function testMethodsShouldBandArrayWithOneBand(): void
    {
        $band = Band::new()->setName(RmString::new('Dipsomania'));
        $this->DataSet = Concert::new()
            ->addBand($band);
        $this->assertEquals(
            true,
            $this->DataSet->hasCurrentBand()
        );
        $this->assertEquals(
            'Dipsomania',
            $this->DataSet->getCurrentBand()->getName()
        );
    }
}
