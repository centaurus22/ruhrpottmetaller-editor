<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\{NullVenue, NullCity};

final class NullVenueTest extends TestCase
{
    private NullVenue $DataSet;

    protected function setUp(): void
    {
        $this->DataSet = NullVenue::new();
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelNullData
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldGetNullStringAsTheName(): void
    {
        $this->assertTrue($this->DataSet->getName()->isNull());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelNullData
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */
    public function testShouldGetNullIntAsTheId(): void
    {
        $this->assertTrue($this->DataSet->getId()->isNull());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\NullVenue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     */
    public function testShouldGetNullBoolAsIsVisibleValue(): void
    {
        $this->assertNull($this->DataSet->getIsVisible()->get());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\NullVenue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldSetCityAndGetSameCityObject(): void
    {
        $this->assertInstanceOf(
            NullCity::class,
            $this->DataSet->getCity()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\NullVenue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */
    public function testShouldCombineVenueNameAndCityName(): void
    {
        $this->assertTrue($this->DataSet->asVenueAndCity()->isNull());
    }
}
