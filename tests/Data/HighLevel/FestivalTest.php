<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\LowLevel\{Date\RmDate, Int\RmInt};

final class FestivalTest extends TestCase
{
    private \ruhrpottmetaller\Data\HighLevel\AbstractEvent $DataSet;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     */
    public function testShouldSetNumberOfDaysAndGetTheSameNumberOfDays(): void
    {
        $this->DataSet = Festival::new();
        $this->DataSet->setNumberOfDays(RmInt::new(23));
        $this->assertEquals(
            23,
            $this->DataSet->getNumberOfDays()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     */
    public function testShouldSetDateStartAndGetTheSameDateStart(): void
    {
        $this->DataSet = Festival::new();
        $this->DataSet->setDateStart(RmDate::new('2922-11-01'));
        $this->assertEquals(
            '2922-11-01',
            $this->DataSet->getDateStart()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testMethodsShouldBeChainable(): void
    {
        $this->DataSet = Festival::new()
            ->setDateStart(RmDate::new('2022-07-07'))
            ->setNumberOfDays(RmInt::new(4));
        $this->assertEquals('2022-07-07', $this->DataSet->getDateStart()->get());
        $this->assertEquals(4, $this->DataSet->getNumberOfDays()->get());
    }

    /**
     * @covers  \ruhrpottmetaller\AbstractRmObject
     * @covers  \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers  \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers  \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses    \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses    \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses    \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses    \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldGetFormattedDate(): void
    {
        $this->DataSet = Festival::new();
        $this->DataSet->setDateStart(RmDate::new('2022-10-22'))
            ->setNumberOfDays(RmInt::new(3));
        $this->assertEquals(
            'Sat, 22. – Mon, 24.',
            $this->DataSet->getFormattedDate()->get()
        );
    }
}
