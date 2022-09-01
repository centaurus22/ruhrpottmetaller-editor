<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Data\HighLevel;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\Venue;
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
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
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
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
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
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
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
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
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
}
