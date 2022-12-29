<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\LowLevel\{Int\RmInt, String\RmString};
use ruhrpottmetaller\Data\HighLevel\NullCity;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\{Connection, QueryCityModel};

final class QueryCityModelTest extends TestCase
{
    private QueryCityModel $queryCityDatabaseModel;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = Connection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->queryCityDatabaseModel = QueryCityModel::new(
            $this->connection,
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE city';
        $this->connection->query($query[0]);
    }


    /**
     * @covers \ruhrpottmetaller\Model\QueryCityModel
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @uses   \ruhrpottmetaller\Model\Connection
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\AbstractRmObject
     */
    public function testShouldReturnDataTypeArray(): void
    {
        $this->assertInstanceOf(
            RmArray::class,
            $this->queryCityDatabaseModel->getCities()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryCityModel
     * @covers \ruhrpottmetaller\Model\Connection
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Model\AbstractModel
     */
    public function testArrayShouldContainEntryIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Dortmund"';
        $this->connection->query($query);
        $this->assertTrue(
            $this->queryCityDatabaseModel->getCities()
                ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryCityModel
     * @covers \ruhrpottmetaller\Model\Connection
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Model\AbstractModel
     */
    public function testArrayShouldGetCityDatasetIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Essen"';
        $this->connection->query($query);
        $this->assertInstanceOf(
            City::class,
            $this->queryCityDatabaseModel->getCities()
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\QueryCityModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testShouldGetCityNameFromDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Mülheim an der Ruhr"';
        $this->connection->query($query);
        $this->assertEquals(
            'Mülheim an der Ruhr',
            $this->queryCityDatabaseModel
                ->getCities()
                ->getCurrent()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\QueryCityModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testShouldGetIdFromDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Mülheim an der Ruhr"';
        $this->connection->query($query);
        $this->assertEquals(
            '1',
            $this->queryCityDatabaseModel
                ->getCities()
                ->getCurrent()
                ->getId()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\QueryCityModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testShouldGetVisibleStatusFromDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Mülheim an der Ruhr", is_visible = 0';
        $this->connection->query($query);
        $this->assertEquals(
            '0',
            $this->queryCityDatabaseModel
                ->getCities()
                ->getCurrent()
                ->getIsVisible()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\QueryCityModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testShouldGetCityById(): void
    {
        $query = 'INSERT INTO city SET name = "Mülheim an der Ruhr", is_visible = 0';
        $this->connection->query($query);
        $this->assertEquals(
            '1',
            $this->queryCityDatabaseModel
                ->getCityById(RmInt::new(1))
                ->getId()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\QueryCityModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */
    public function testShouldGetNullCity(): void
    {
        $this->assertInstanceOf(
            NullCity::class,
            $this->queryCityDatabaseModel->getCityById(RmInt::new(null))
        );
    }
}
