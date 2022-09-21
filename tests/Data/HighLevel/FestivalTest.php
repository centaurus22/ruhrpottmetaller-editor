<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\LowLevel\RmDate;
use ruhrpottmetaller\Data\LowLevel\RmInt;

final class FestivalTest extends TestCase
{
    private \ruhrpottmetaller\Data\HighLevel\AbstractEvent $DataSet;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmInt
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
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmDate
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
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\RmString
     */
    public function testMethodsShouldBeChainable(): void
    {
        $this->DataSet = Festival::new()
            ->setDateStart(RmDate::new('2022-07-07'))
            ->setNumberOfDays(RmInt::new(4));
        $this->assertEquals('2022-07-07', $this->DataSet->getDateStart()->get());
        $this->assertEquals(4, $this->DataSet->getNumberOfDays()->get());
    }
}
