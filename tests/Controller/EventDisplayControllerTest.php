<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\EventDisplayController;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\LowLevel\RmDate;
use ruhrpottmetaller\Data\LowLevel\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\View\View;

final class EventDisplayControllerTest extends TestCase
{
    private EventDisplayController $Controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\EventDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\RmBool
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\RmInt
     * @uses \ruhrpottmetaller\Controller\BaseDisplayController
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @throws \Exception
     */
    public function testShouldSetConcertList()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new EventDisplayController(
            $BaseView,
            new QueryEventDatabaseModelMock(null, null)
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
     * @covers \ruhrpottmetaller\Controller\EventDisplayController
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\RmString
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Controller\BaseDisplayController
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @throws \Exception
     */
    public function testShouldNotSetEmptyConcertList()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new EventDisplayController(
            $BaseView,
            new QueryEventDatabaseModelMockEmpty(null, null)
        );

        $this->Controller->setMonth(RmDate::new('2022-10'));
        $this->Controller->render();

        $this->assertArrayNotHasKey('events', $this->Controller->getViewData());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\EventDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\RmBool
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\RmInt
     * @uses \ruhrpottmetaller\Controller\BaseDisplayController
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @throws \Exception
     */
    public function testShouldSetMonth()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new EventDisplayController(
            $BaseView,
            new QueryEventDatabaseModelMock(null, null)
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
}
