<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\VenueMainDisplayController;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\View\View;

final class VenueMainDisplayControllerTest extends TestCase
{
    private VenueMainDisplayController $Controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\VenueMainDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmNullString
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Controller\BaseDisplayController
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Model\AbstractModel
     * @uses \ruhrpottmetaller\Model\VenueQueryModel
     */
    public function testShouldSetCityList()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new VenueMainDisplayController(
            $BaseView,
            new VenueDatabaseQueryModelMock(
                null,
                new CityQueryDatabaseModelMock(null)
            )
        );

        $this->Controller
            ->setGetParameters(RmString::new(null), RmString::new(null))
            ->render();

        $this->assertArrayHasKey('venues', $this->Controller->getViewData());
        $this->assertInstanceOf(
            RmArray::class,
            ($this->Controller->getViewData())['venues']
        );
        $this->assertInstanceOf(
            Venue::class,
            ($this->Controller->getViewData()['venues'])->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\VenueMainDisplayController
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmNullString
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Controller\BaseDisplayController
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Model\AbstractModel
     * @uses \ruhrpottmetaller\Model\VenueQueryModel
     */
    public function testShouldNotSetEmptyConcertList()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new VenueMainDisplayController(
            $BaseView,
            new VenueDatabaseQueryModelMockEmpty(
                null,
                new CityQueryDatabaseModelMock(null)
            )
        );

        $this->Controller
            ->setGetParameters(RmString::new(null), RmString::new(null))
            ->render();

        $this->assertArrayNotHasKey('venues', $this->Controller->getViewData());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\VenueMainDisplayController
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmNullString
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Controller\BaseDisplayController
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Model\AbstractModel
     * @uses \ruhrpottmetaller\Model\VenueQueryModel
     */
    public function testShouldSetGetParameterString()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new VenueMainDisplayController(
            $BaseView,
            new VenueDatabaseQueryModelMockEmpty(
                null,
                new CityQueryDatabaseModelMock(null)
            )
        );

        $this->Controller
            ->setGetParameters(RmString::new('1'), RmString::new('name'))
            ->render();

        $this->assertEquals(
            '1',
            ($this->Controller->getViewData())['filterByParameter']
        );

        $this->assertEquals(
            'name',
            ($this->Controller->getViewData())['orderByParameter']
        );
    }
}
