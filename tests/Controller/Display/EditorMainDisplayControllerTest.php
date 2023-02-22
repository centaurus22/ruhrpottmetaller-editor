<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller\Display;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\Display\EditorMainDisplayController;
use ruhrpottmetaller\Data\HighLevel\Concert;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\HighLevel\NullEvent;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\BandQueryModel;
use ruhrpottmetaller\Model\CityQueryModel;
use ruhrpottmetaller\Model\EventQueryModel;
use ruhrpottmetaller\Model\GigQueryModel;
use ruhrpottmetaller\Model\VenueQueryModel;
use ruhrpottmetaller\View\View;
use tests\ruhrpottmetaller\Controller\EventQueryDatabaseModelMock;

final class EditorMainDisplayControllerTest extends TestCase
{
    private EditorMainDisplayController $controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorMainDisplayController
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
     */
    public function testShouldSetEvent()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->controller = new EditorMainDisplayController(
            $BaseView,
            new EventQueryDatabaseModelMock(
                null,
                GigQueryModel::new(
                    null,
                    BandQueryModel::new(null)
                ),
                VenueQueryModel::new(
                    null,
                    CityQueryModel::new(null)
                )
            ),
            NullEvent::new()
        );

        $this->controller->render();

        $this->assertArrayHasKey('event', $this->controller->getViewData());
        $this->assertInstanceOf(
            NullEvent::class,
            ($this->controller->getViewData())['event']
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorMainDisplayController
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
     */
    public function testShouldSetEventById()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $event = Concert::new()->setId(RmInt::new(1));

        $this->controller = new EditorMainDisplayController(
            $BaseView,
            new EventQueryDatabaseModelMock(
                null,
                GigQueryModel::new(
                    null,
                    BandQueryModel::new(null)
                ),
                VenueQueryModel::new(
                    null,
                    CityQueryModel::new(null)
                )
            ),
            $event
        );

        $this->controller->render();

        $this->assertArrayHasKey('event', $this->controller->getViewData());
        $this->assertInstanceOf(
            Festival::class,
            ($this->controller->getViewData())['event']
        );
    }
}
