<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\CityMainDisplayController;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\View\View;

final class CityMainDisplayControllerTest extends TestCase
{
    private CityMainDisplayController $Controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\CityMainDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
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
     * @uses \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testShouldSetCityList()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new CityMainDisplayController(
            $BaseView,
            new QueryCityDatabaseModelMock(null, null),
            RmString::new(null),
            RmString::new(null)
        );

        $this->Controller->render();

        $this->assertArrayHasKey('cities', $this->Controller->getViewData());
        $this->assertInstanceOf(
            RmArray::class,
            ($this->Controller->getViewData())['cities']
        );
        $this->assertInstanceOf(
            City::class,
            ($this->Controller->getViewData()['cities'])->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\CityMainDisplayController
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

        $this->Controller = new CityMainDisplayController(
            $BaseView,
            new QueryCityDatabaseModelMockEmpty(null, null),
            RmString::new(null),
            RmString::new(null)
        );

        $this->Controller->render();

        $this->assertArrayNotHasKey('cities', $this->Controller->getViewData());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\CityMainDisplayController
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
    public function testShouldSetGetParameterString()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new CityMainDisplayController(
            $BaseView,
            new QueryCityDatabaseModelMockEmpty(null),
            RmString::new(null),
            RmString::new(null)
        );

        $this->Controller->render();

        $this->assertArrayHasKey(
            'getParameters',
            $this->Controller->getViewData()
        );

        $this->assertEquals(
            '?show=cities',
            ($this->Controller->getViewData())['getParameters']
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\CityMainDisplayController
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
    public function testShouldSetGetParameterStringContainingFilter()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new CityMainDisplayController(
            $BaseView,
            new QueryCityDatabaseModelMockEmpty(null),
            RmString::new('A'),
            RmString::new(null)
        );

        $this->Controller->render();

        $this->assertEquals(
            '?show=cities&filter_by=A',
            ($this->Controller->getViewData())['getParameters']
        );
    }

/**
 * @covers \ruhrpottmetaller\AbstractRmObject
 * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
 * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
 * @covers \ruhrpottmetaller\Controller\CityMainDisplayController
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
    public function testShouldSetGetParameterStringContainingOrder()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new CityMainDisplayController(
            $BaseView,
            new QueryCityDatabaseModelMockEmpty(null),
            RmString::new(null),
            RmString::new('name')
        );

        $this->Controller->render();

        $this->assertEquals(
            '?show=cities&order_by=name',
            ($this->Controller->getViewData())['getParameters']
        );
    }
}
