<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\{City, Venue};
use ruhrpottmetaller\Data\LowLevel\{Bool\RmBool, Int\RmInt};
use ruhrpottmetaller\Data\LowLevel\String\{AbstractRmString, RmString};

final class VenueTest extends TestCase
{
    private Venue $DataSet;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldSetNameAndGetSameNameBack(): void
    {
        $this->DataSet = Venue::new();
        $this->DataSet->setName(RmString::new('Essen'));
        $this->assertEquals(
            'Essen',
            $this->DataSet->getName()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     */
    public function testShouldSetIdAndGetSameIdBack(): void
    {
        $this->DataSet = Venue::new();
        $this->DataSet->setId(RmInt::new(123));
        $this->assertEquals(
            '123',
            $this->DataSet->getId()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldSetDefaultUrlAndGetSameDefaultUrlBack(): void
    {
        $this->DataSet = Venue::new();
        $this->DataSet->setUrlDefault(RmString::new('www.matrix-bochum.de'));
        $this->assertEquals(
            'www.matrix-bochum.de',
            $this->DataSet->getUrlDefault()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     */
    public function testShouldSetIsVisibleAndGetSameIsVisibleValue(): void
    {
        $this->DataSet = Venue::new();
        $this->DataSet->setIsVisible(RmBool::new(true));
        $this->assertEquals(
            true,
            $this->DataSet->getIsVisible()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldSetCityAndGetSameCityObject(): void
    {
        $this->DataSet = Venue::new();
        $City = City::new()->setName(RmString::new('Duisburg'));
        $this->DataSet->setCity($City);
        $this->assertEquals(
            'Duisburg',
            $this->DataSet->getCity()->getName()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldCombineVenueNameAndCityName(): void
    {
        $this->DataSet = Venue::new()->setName(AbstractRmString::new('Parkhaus'));
        $City = City::new()->setName(AbstractRmString::new('Duisburg'));
        $this->DataSet->setCity($City);
        $this->assertEquals(
            'Parkhaus, Duisburg',
            $this->DataSet->asVenueAndCity()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */
    public function testShouldCombineVenueNameAndEmptyCityName(): void
    {
        $this->DataSet = Venue::new()->setName(AbstractRmString::new('Parkhaus'));
        $City = City::new()->setName(AbstractRmString::new(null));
        $this->DataSet->setCity($City);
        $this->assertEquals(
            'Parkhaus',
            $this->DataSet->asVenueAndCity()
        );
    }
}
