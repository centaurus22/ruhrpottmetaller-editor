<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\RmInt;
use ruhrpottmetaller\Data\LowLevel\RmString;
use ruhrpottmetaller\Data\LowLevel\RmBool;

final class VenueTest extends TestCase
{
    private Venue $DataSet;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmString
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
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmInt
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
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmBool
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
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\RmString
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
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractRmString
     */
    public function testShouldCombineVenueNameAndCityName(): void
    {
        $this->DataSet = Venue::new()->setName(AbstractRmString::new('Parkhaus'));
        $City = City::new()->setName(AbstractRmString::new('Duisburg'));
        $this->DataSet->setCity($City)->combineVenueAndCityName();
        $this->assertEquals(
            'Parkhaus, Duisburg',
            $this->DataSet->getName()->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractRmString
     */
    public function testShouldCombineVenueNameAndEmptyCityName(): void
    {
        $this->DataSet = Venue::new()->setName(AbstractRmString::new('Parkhaus'));
        $City = City::new()->setName(AbstractRmString::new(null));
        $this->DataSet->setCity($City)->combineVenueAndCityName();
        $this->assertEquals(
            'Parkhaus',
            $this->DataSet->getName()->get()
        );
    }
}
