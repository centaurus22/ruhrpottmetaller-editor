<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller\Display;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\Display\EditorMainDisplayController;
use ruhrpottmetaller\Data\HighLevel\Concert;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\HighLevel\NullEvent;
use ruhrpottmetaller\Data\HighLevel\NullVenue;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmNullString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\BandQueryModel;
use ruhrpottmetaller\Model\CityQueryModel;
use ruhrpottmetaller\Model\DatabaseGigQueryModel;
use ruhrpottmetaller\Model\DatabaseVenueQueryModel;
use ruhrpottmetaller\View\View;
use tests\ruhrpottmetaller\Controller\CityQueryDatabaseModelMock;
use tests\ruhrpottmetaller\Controller\DatabaseEventQueryDatabaseModelMock;

final class EditorMainDisplayControllerTest extends TestCase
{
    private EditorMainDisplayController $controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorMainDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses \ruhrpottmetaller\Controller\Display\BaseDisplayController
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelNullData
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseEventQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseGigQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     * @uses \ruhrpottmetaller\Model\BandQueryModel
     */
    public function testShouldSetNullEventIfNoIdIsGiven()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $cityQueryModel = CityQueryDatabaseModelMock::new(null);

        $this->controller = new EditorMainDisplayController(
            $BaseView,
            new DatabaseEventQueryDatabaseModelMock(
                null,
                DatabaseGigQueryModel::new(
                    null,
                    BandQueryModel::new(null)
                ),
                DatabaseVenueQueryModel::new(
                    null,
                    $cityQueryModel
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
     * @uses \ruhrpottmetaller\Controller\Display\BaseDisplayController
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseEventQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseGigQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     * @uses \ruhrpottmetaller\Model\BandQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelNullData
     * @uses \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     */
    public function testShouldSetEventById()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $event = Concert::new()
            ->setId(RmInt::new(1))
            ->setName(RmNullString::new(null))
            ->setUrl(RmNullString::new(null))
            ->setVenue(NullVenue::new());

        $cityQueryModel = CityQueryDatabaseModelMock::new(null);
        $this->controller = new EditorMainDisplayController(
            $BaseView,
            new DatabaseEventQueryDatabaseModelMock(
                null,
                DatabaseGigQueryModel::new(
                    null,
                    BandQueryModel::new(null)
                ),
                DatabaseVenueQueryModel::new(
                    null,
                    $cityQueryModel
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

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorMainDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\HighLevel\City
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
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseEventQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseGigQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     * @uses \ruhrpottmetaller\Model\BandQueryModel
     */
    public function testShouldNotLoadEventIfEventIsNotEmpty()
    {
        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $event = Concert::new()
            ->setId(RmInt::new(1))
            ->setName(RmString::new('Ragers-Elite-Festival'));

        $cityQueryModel = CityQueryDatabaseModelMock::new(null);

        $this->controller = new EditorMainDisplayController(
            $BaseView,
            new DatabaseEventQueryDatabaseModelMock(
                null,
                DatabaseGigQueryModel::new(
                    null,
                    BandQueryModel::new(null)
                ),
                DatabaseVenueQueryModel::new(
                    null,
                    $cityQueryModel
                )
            ),
            $event
        );

        $this->controller->render();

        $this->assertArrayHasKey('event', $this->controller->getViewData());
        $this->assertInstanceOf(
            Concert::class,
            ($this->controller->getViewData())['event']
        );
    }
}
