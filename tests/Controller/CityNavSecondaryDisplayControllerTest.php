<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\CityNavSecondaryDisplayController;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\CityQueryModel;
use ruhrpottmetaller\Model\Connection;
use ruhrpottmetaller\View\View;

final class CityNavSecondaryDisplayControllerTest extends TestCase
{
    private CityNavSecondaryDisplayController $Controller;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = Connection::new($ConnectionInformationFile)
            ->connect()
            ->getConnection();
        $queryCityDatabaseModel = CityQueryModel::new(
            $this->connection,
        );

        $BaseView = View::new(
            RmString::new('./tests/Controller/templates/'),
            RmString::new('testTemplate')
        );

        $this->Controller = new CityNavSecondaryDisplayController(
            $BaseView,
            $queryCityDatabaseModel
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE city';
        $this->connection->query($query[0]);
    }


    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\AbstractDisplayController
     * @covers \ruhrpottmetaller\Controller\AbstractDataMainDisplayController
     * @covers \ruhrpottmetaller\Controller\CityNavSecondaryDisplayController
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Model\AbstractModel
     * @uses \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\View\View
     */
    public function testShouldSetCityList()
    {
        $this->connection->query('INSERT INTO city SET NAME = "Duisburg"');

        $this->Controller
            ->setGetParameters(RmString::new(null), RmString::new(null))
            ->render();

        $this->assertArrayHasKey('cities', $this->Controller->getViewData());
        $this->assertInstanceOf(
            RmArray::class,
            ($this->Controller->getViewData())['cities']
        );
        $this->assertInstanceOf(
            City::class,
            ($this->Controller->getViewData()['cities'])->getCurrent()
        );

        $this->assertEquals(
            'Duisburg',
            ($this->Controller->getViewData()['cities'])->getCurrent()->getName()
        );
    }
}
