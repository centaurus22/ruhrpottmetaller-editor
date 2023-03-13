<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller\Display;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\Display\EditorAjaxCityVenueDisplayController;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use tests\ruhrpottmetaller\Controller\CityQueryDatabaseModelMock;

final class EditorAjaxCityVenueDisplayControllerTest extends TestCase
{
    private EditorAjaxCityVenueDisplayController $controller;

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\Display\EditorAjaxCityVenueDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\View\View
     * @uses \ruhrpottmetaller\Model\AbstractModel
     * @uses \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     */
    public function testShouldLoadCities()
    {
        $view = \ruhrpottmetaller\View\View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );
        $this->controller = new EditorAjaxCityVenueDisplayController(
            $view,
            CityQueryDatabaseModelMock::new(null)
        );

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
}
