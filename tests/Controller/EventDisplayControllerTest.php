<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\EventDisplayController;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\LowLevel\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\View\View;

final class EventDisplayControllerTest extends TestCase
{
    private EventDisplayController $Controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\BaseDisplayController
     * @covers \ruhrpottmetaller\Controller\EventDisplayController
     * @covers \ruhrpottmetaller\View\View
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @covers \ruhrpottmetaller\Data\HighLevel\Venue
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
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

        $this->Controller->setMonth(RmString::new('2022-10'));
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
}
