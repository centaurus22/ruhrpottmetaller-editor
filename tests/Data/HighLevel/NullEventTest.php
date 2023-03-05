<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\NullEvent;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;

final class NullEventTest extends TestCase
{
    private NullEvent $dataSet;

    protected function setUp(): void
    {
        $this->dataSet = NullEvent::new();
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelNullData
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\NullEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */
    public function testShouldGetName(): void
    {
        $this->assertTrue($this->dataSet->getName()->isNull());
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelNullData
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\NullEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     */
    public function testShouldGetNumberOfDays(): void
    {
        $this->assertEquals(1, $this->dataSet->getNumberOfDays()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelNullData
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\NullEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     */
    public function testShouldGetDate(): void
    {
        $this->dataSet->setDate(RmDate::new('2922-12-12'));
        $this->assertEquals('2922-12-12', $this->dataSet->getDate());
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelNullData
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\NullEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */
    public function testShouldGetUrl(): void
    {
        $this->assertNull($this->dataSet->getUrl()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelNullData
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\NullEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     */
    public function testShouldGetVenueId(): void
    {
        $this->assertNull($this->dataSet->getVenueId()->get());
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelNullData
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\NullEvent
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     */
    public function testShouldGetCityId(): void
    {
        $this->assertNull($this->dataSet->getCityId()->get());
    }
}
