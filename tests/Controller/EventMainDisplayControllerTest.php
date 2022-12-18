<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Model\{QueryCityDatabaseModel, QueryVenueDatabaseModel};
use ruhrpottmetaller\Controller\EventMainDisplayController;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\LowLevel\{Date\RmDate, String\RmString};
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
     * @covers   \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryVenueDatabaseModel
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
     * @uses \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testShouldSetConcertList()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new EventMainDisplayController(
            $BaseView,
            new QueryEventDatabaseModelMock(
                null,
                QueryVenueDatabaseModel::new(
                    null,
                    QueryCityDatabaseModel::new(null)
                )
            ),
            RmString::new(null),
            RmString::new(null)
        );

        $this->Controller->setMonth(RmDate::new('2022-10'));
        $this->Controller->render();

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
     * @uses  \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
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
     * @uses \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testShouldNotSetEmptyConcertList()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new EventMainDisplayController(
            $BaseView,
            new QueryEventDatabaseModelMockEmpty(
                null,
                QueryVenueDatabaseModelMock::new(
                    null,
                    QueryCityDatabaseModelMock::new(null)
                )
            ),
            RmString::new(null),
            RmString::new(null)
        );

        $this->Controller->setMonth(RmDate::new('2022-10'));
        $this->Controller->render();

        $this->assertArrayNotHasKey('events', $this->Controller->getViewData());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\EventMainDisplayController
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryCityDatabaseModel
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
     * @uses \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testShouldSetMonth()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new EventMainDisplayController(
            $BaseView,
            new QueryEventDatabaseModelMock(
                null,
                QueryVenueDatabaseModelMock::new(
                    null,
                    QueryCityDatabaseModelMock::new(null)
                )
            ),
            RmString::new(null),
            RmString::new(null)
        );

        $this->Controller->setMonth(RmDate::new('2022-10'));
        $this->Controller->render();

        $this->assertArrayHasKey('month', $this->Controller->getViewData());
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
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryCityDatabaseModel
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
     * @uses \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testShouldSetGetParameterStringContainingOrder()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new EventMainDisplayController(
            $BaseView,
            new QueryEventDatabaseModelMock(
                null,
                QueryVenueDatabaseModelMock::new(
                    null,
                    QueryCityDatabaseModelMock::new(null)
                )
            ),
            RmString::new('2022-11'),
            RmString::new(null)
        );

        $this->Controller->setMonth(RmDate::new('2022-11'));
        $this->Controller->render();

        $this->assertEquals(
            '2022-11',
            ($this->Controller->getViewData())['filterByParameter']
        );
    }
}
