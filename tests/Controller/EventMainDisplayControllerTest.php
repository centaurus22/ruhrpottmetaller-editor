<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Model\{CityQueryModel, VenueQueryModel};
use ruhrpottmetaller\Controller\EventMainDisplayController;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\View\View;

final class EventMainDisplayControllerTest extends TestCase
{
    private EventMainDisplayController $Controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\EventMainDisplayController
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses  \ruhrpottmetaller\Model\VenueQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
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
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Model\AbstractModel
     */
    public function testShouldSetConcertList()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new EventMainDisplayController(
            $BaseView,
            new EventQueryDatabaseModelMock(
                null,
                VenueQueryModel::new(
                    null,
                    CityQueryModel::new(null)
                )
            )
        );

        $this->Controller
            ->setGetParameters(RmString::new(null), RmString::new(null))
            ->render();

        $this->assertArrayHasKey('events', $this->Controller->getViewData());
        $this->assertInstanceOf(
            RmArray::class,
            ($this->Controller->getViewData())['events']
        );
        $this->assertInstanceOf(
            Festival::class,
            ($this->Controller->getViewData()['events'])->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\EventMainDisplayController
     * @uses  \ruhrpottmetaller\Model\EventQueryModel
     * @uses  \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
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
     */
    public function testShouldNotSetEmptyConcertList()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new EventMainDisplayController(
            $BaseView,
            new EventQueryDatabaseModelMockEmpty(
                null,
                VenueDatabaseQueryModelMock::new(
                    null,
                    CityQueryDatabaseModelMock::new(null)
                )
            )
        );

        $this->Controller
            ->setGetParameters(RmString::new(null), RmString::new(null))
            ->render();

        $this->assertArrayNotHasKey('events', $this->Controller->getViewData());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\EventMainDisplayController
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @uses \ruhrpottmetaller\Model\VenueQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmNullString
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Controller\BaseDisplayController
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Model\AbstractModel
     */
    public function testShouldSetGetParameterStringContainingOrder()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new EventMainDisplayController(
            $BaseView,
            new EventQueryDatabaseModelMock(
                null,
                VenueDatabaseQueryModelMock::new(
                    null,
                    CityQueryDatabaseModelMock::new(null)
                )
            )
        );

        $this->Controller
            ->setGetParameters(RmString::new('2022-11'), RmString::new(null))
            ->render();

        $this->assertEquals(
            '2022-11',
            ($this->Controller->getViewData())['filterByParameter']
        );
    }
}
