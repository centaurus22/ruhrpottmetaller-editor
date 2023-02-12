<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\NullVenue;
use ruhrpottmetaller\Data\LowLevel\Int\RmNullInt;
use ruhrpottmetaller\Data\LowLevel\String\RmNullString;

final class NullVenueTest extends TestCase
{
    private NullVenue $dataSet;

    protected function setUp(): void
    {
        $this->dataSet = NullVenue::new();
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelNullData
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldGetNullStringAsTheName(): void
    {
        $this->assertTrue($this->dataSet->getName()->isNull());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelNullData
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */
    public function testShouldGetNullIntAsTheId(): void
    {
        $this->assertTrue($this->dataSet->getId()->isNull());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelNullData
     * @covers \ruhrpottmetaller\Data\HighLevel\NullVenue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */
    public function testShouldGetNullStringAsTheDefaultUrl(): void
    {
        $this->assertTrue($this->dataSet->getUrlDefault()->isNull());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\NullVenue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     */
    public function testShouldGetNullBoolAsIsVisibleValue(): void
    {
        $this->assertNull($this->dataSet->getIsVisible()->get());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\NullVenue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldSetCityNullCityAndGetNullCityName(): void
    {
        $this->assertInstanceOf(
            RmNullString::class,
            $this->dataSet->getCityName()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\NullVenue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */
    public function testShouldCombineVenueNameAndCityName(): void
    {
        $this->assertTrue($this->dataSet->asVenueAndCity()->isNull());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\NullVenue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */
    public function testShouldCombineFormattedVenueNameAndCityName(): void
    {
        $this->assertTrue($this->dataSet->asFormattedVenueAndCity()->isNull());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\NullVenue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldGetNullAsCityId(): void
    {
        $this->assertNull(
            $this->dataSet->getCityId()->get()
        );
    }
}
