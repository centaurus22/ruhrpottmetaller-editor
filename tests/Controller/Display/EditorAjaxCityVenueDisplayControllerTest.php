<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller\Display;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\Display\EditorAjaxCityVenueDisplayController;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\Int\RmNullInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\View\View;
use tests\ruhrpottmetaller\Controller\CityQueryDatabaseModelMock;
use tests\ruhrpottmetaller\Controller\DatabaseVenueQueryDatabaseModelMock;

final class EditorAjaxCityVenueDisplayControllerTest extends TestCase
{
    private const NEW_CITY = 1;
    private const NEW_VENUE = 1;
    private EditorAjaxCityVenueDisplayController $controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorAjaxCityVenueDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     */
    public function testShouldLoadCities()
    {
        $view = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );
        $cityQueryDatabaseModel = CityQueryDatabaseModelMock::new(null);
        $this->controller = new EditorAjaxCityVenueDisplayController(
            $view,
            CityQueryDatabaseModelMock::new(null),
            DatabaseVenueQueryDatabaseModelMock::new(null, $cityQueryDatabaseModel)
        );

        $this->controller->setCityId(RmNullInt::new(null));
        $this->controller->setVenueId(RmNullInt::new(null));
        $this->controller->render();

        $this->assertArrayHasKey('cities', $this->controller->getViewData());
        $cities = ($this->controller->getViewData())['cities'];
        $this->assertInstanceOf(
            RmArray::class,
            $cities
        );
        $this->assertEquals(
            'Essen',
            $cities->getCurrent()->getName()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorAjaxCityVenueDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     */
    public function testShouldLoadVenuesIfCityIdIsNull()
    {
        $view = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $cityQueryDatabaseModel = CityQueryDatabaseModelMock::new(null);
        $this->controller = new EditorAjaxCityVenueDisplayController(
            $view,
            $cityQueryDatabaseModel::new(null),
            DatabaseVenueQueryDatabaseModelMock::new(null, $cityQueryDatabaseModel)
        );

        $this->controller->setCityId(RmNullInt::new(null));
        $this->controller->setVenueId(RmNullInt::new(null));
        $this->controller->render();

        $this->assertArrayHasKey('venues', $this->controller->getViewData());
        $venues = ($this->controller->getViewData())['venues'];
        $this->assertInstanceOf(
            RmArray::class,
            $venues
        );
        $this->assertEquals(
            'Turock',
            $venues->getCurrent()->getName()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorAjaxCityVenueDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     */
    public function testShouldPassGetNewCityValueToView()
    {
        $view = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $cityQueryDatabaseModel = CityQueryDatabaseModelMock::new(null);
        $this->controller = new EditorAjaxCityVenueDisplayController(
            $view,
            $cityQueryDatabaseModel::new(null),
            DatabaseVenueQueryDatabaseModelMock::new(null, $cityQueryDatabaseModel)
        );

        $this->controller->setCityId(RmNullInt::new(null));
        $this->controller->setVenueId(RmNullInt::new(null));
        $this->controller->render();

        $this->assertArrayHasKey('getNewCity', $this->controller->getViewData());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorAjaxCityVenueDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     */
    public function testShouldPassTrueAsGetNewCityValueToView()
    {
        $view = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $cityQueryDatabaseModel = CityQueryDatabaseModelMock::new(null);
        $this->controller = new EditorAjaxCityVenueDisplayController(
            $view,
            $cityQueryDatabaseModel::new(null),
            DatabaseVenueQueryDatabaseModelMock::new(null, $cityQueryDatabaseModel)
        );

        $this->controller->setCityId(RmNullInt::new(self::NEW_CITY));
        $this->controller->render();

        $this->assertArrayHasKey('getNewCity', $this->controller->getViewData());
        $this->assertTrue($this->controller->getViewData()['getNewCity']->isTrue());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorAjaxCityVenueDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     */
    public function testShouldPassGetNewVenueValueToView()
    {
        $view = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $cityQueryDatabaseModel = CityQueryDatabaseModelMock::new(null);
        $this->controller = new EditorAjaxCityVenueDisplayController(
            $view,
            $cityQueryDatabaseModel::new(null),
            DatabaseVenueQueryDatabaseModelMock::new(null, $cityQueryDatabaseModel)
        );

        $this->controller->setCityId(RmNullInt::new(self::NEW_CITY));
        $this->controller->render();

        $this->assertArrayHasKey('getNewVenue', $this->controller->getViewData());
        $this->assertTrue($this->controller->getViewData()['getNewVenue']->isTrue());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorAjaxCityVenueDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     */
    public function testShouldPassTrueAsGetNewVenueValueToView()
    {
        $view = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $cityQueryDatabaseModel = CityQueryDatabaseModelMock::new(null);
        $this->controller = new EditorAjaxCityVenueDisplayController(
            $view,
            $cityQueryDatabaseModel::new(null),
            DatabaseVenueQueryDatabaseModelMock::new(null, $cityQueryDatabaseModel)
        );

        $this->controller->setCityId(RmNullInt::new(null));
        $this->controller->setVenueId(RmInt::new(self::NEW_VENUE));
        $this->controller->render();

        $this->assertArrayHasKey('getNewVenue', $this->controller->getViewData());
        $this->assertTrue($this->controller->getViewData()['getNewVenue']->isTrue());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorAjaxCityVenueDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmFalse
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     */
    public function testShouldPassFalseAsGetNewVenueValueToView()
    {
        $view = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $cityQueryDatabaseModel = CityQueryDatabaseModelMock::new(null);
        $this->controller = new EditorAjaxCityVenueDisplayController(
            $view,
            $cityQueryDatabaseModel::new(null),
            DatabaseVenueQueryDatabaseModelMock::new(null, $cityQueryDatabaseModel)
        );

        $this->controller->setCityId(RmNullInt::new(null));
        $this->controller->setVenueId(RmNullInt::new(null));
        $this->controller->render();

        $this->assertTrue($this->controller->getViewData()['getNewVenue']->isFalse());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorAjaxCityVenueDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmFalse
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     */
    public function testShouldPassNoCitiesToViewIfNewCityShouldBeCreated()
    {
        $view = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $cityQueryDatabaseModel = CityQueryDatabaseModelMock::new(null);
        $this->controller = new EditorAjaxCityVenueDisplayController(
            $view,
            $cityQueryDatabaseModel::new(null),
            DatabaseVenueQueryDatabaseModelMock::new(null, $cityQueryDatabaseModel)
        );

        $this->controller->setCityId(RmNullInt::new(self::NEW_CITY));
        $this->controller->setVenueId(RmNullInt::new(null));
        $this->controller->render();

        $this->assertArrayNotHasKey('venues', $this->controller->getViewData());
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorAjaxCityVenueDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmFalse
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     */
    public function testShouldPassOnlyVenuesInTheCityToTheView()
    {
        $view = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $cityQueryDatabaseModel = CityQueryDatabaseModelMock::new(null);
        $this->controller = new EditorAjaxCityVenueDisplayController(
            $view,
            $cityQueryDatabaseModel::new(null),
            DatabaseVenueQueryDatabaseModelMock::new(null, $cityQueryDatabaseModel)
        );

        $this->controller->setCityId(RmInt::new(3));
        $this->controller->setVenueId(RmNullInt::new(null));
        $this->controller->render();

        $this->assertEquals(
            'JunkYard',
            $this->controller->getViewData()['venues']->getCurrent()->getName()
        );
    }
}
