<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller\Display\Main;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\Display\Main\EventMainDisplayController;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseGigQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel;
use ruhrpottmetaller\View\View;
use tests\ruhrpottmetaller\Controller\DatabaseEventQueryDatabaseModelMock;

final class EventMainDisplayControllerTest extends TestCase
{
    private EventMainDisplayController $Controller;

    protected function setUp(): void
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );
        $this->Controller = new EventMainDisplayController(
            $BaseView,
            new DatabaseEventQueryDatabaseModelMock(
                null,
                DatabaseGigQueryModel::new(
                    null,
                    DatabaseBandQueryModel::new(null)
                ),
                DatabaseVenueQueryModel::new(
                    null,
                    DatabaseCityQueryModel::new(null)
                )
            )
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\Main\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\Main\EventMainDisplayController
     * @covers \ruhrpottmetaller\Model\Query\DatabaseEventQueryModel
     * @uses  \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses  \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @uses  \ruhrpottmetaller\Model\Query\DatabaseGigQueryModel
     * @uses  \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses \ruhrpottmetaller\Controller\Display\BaseDisplayController
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Data\HighLevel\Event
     * @uses \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     */
    public function testShouldSetConcertList()
    {
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
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\Main\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\Main\EventMainDisplayController
     * @covers \ruhrpottmetaller\Model\Query\DatabaseEventQueryModel
     * @uses \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @uses \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses  \ruhrpottmetaller\Model\Query\DatabaseGigQueryModel
     * @uses  \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses \ruhrpottmetaller\Controller\Display\BaseDisplayController
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Data\HighLevel\Event
     * @uses \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     */
    public function testShouldSetGetParameterStringContainingOrder()
    {
        $this->Controller
            ->setGetParameters(RmString::new('2022-11'), RmString::new(null))
            ->render();

        $this->assertEquals(
            '2022-11',
            ($this->Controller->getViewData())['filterByParameter']
        );
    }
}
