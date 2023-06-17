<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\LowLevel\{Int\RmInt, String\RmString};
use ruhrpottmetaller\Data\HighLevel\NullCity;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\{DatabaseConnection, DatabaseCityQueryModel};

final class CityQueryModelTest extends TestCase
{
    private DatabaseCityQueryModel $cityQueryModel;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = DatabaseConnection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->cityQueryModel = DatabaseCityQueryModel::new(
            $this->connection,
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE city';
        $this->connection->query($query[0]);
    }


    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\RmArray
     */
    public function testShouldReturnDataTypeArray(): void
    {
        $this->assertInstanceOf(
            RmArray::class,
            $this->cityQueryModel->getCities()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseConnection
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseModel
     */
    public function testArrayShouldContainEntryIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Dortmund"';
        $this->connection->query($query);
        $this->assertTrue(
            $this->cityQueryModel->getCities()
                ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseConnection
     * @covers \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseModel
     */
    public function testArrayShouldGetCityDatasetIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Essen"';
        $this->connection->query($query);
        $this->assertInstanceOf(
            City::class,
            $this->cityQueryModel->getCities()
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldGetCityNameFromDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Mülheim an der Ruhr"';
        $this->connection->query($query);
        $this->assertEquals(
            'Mülheim an der Ruhr',
            $this->cityQueryModel
                ->getCities()
                ->getCurrent()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldGetIdFromDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Mülheim an der Ruhr"';
        $this->connection->query($query);
        $this->assertEquals(
            '1',
            $this->cityQueryModel
                ->getCities()
                ->getCurrent()
                ->getId()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldGetVisibleStatusFromDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Mülheim an der Ruhr", is_visible = 0';
        $this->connection->query($query);
        $this->assertEquals(
            '0',
            $this->cityQueryModel
                ->getCities()
                ->getCurrent()
                ->getIsVisible()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldGetCityById(): void
    {
        $query = 'INSERT INTO city SET name = "Mülheim an der Ruhr", is_visible = 0';
        $this->connection->query($query);
        $this->assertEquals(
            '1',
            $this->cityQueryModel
                ->getCityById(RmInt::new(1))
                ->getId()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
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
            $this->cityQueryModel->getCityById(RmInt::new(null))
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseBandQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\Band
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldFilterByFirstChar(): void
    {
        $query[] = 'INSERT INTO city SET name = "Hagen"';
        $query[] = 'INSERT INTO city SET name = "Gelsenkirchen"';
        $this->connection->query($query[0]);
        $this->connection->query($query[1]);
        $this->assertEquals(
            'Gelsenkirchen',
            $this->cityQueryModel
                ->getCitiesByFirstChar(RmString::new('G'))
                ->getCurrent()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseBandQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses  \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\Band
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldFindBandsWhoseNameStartWithASpecialChar(): void
    {
        $query[] = 'INSERT INTO city SET name = "Dortmund", is_visible = 0';
        $query[] = 'INSERT INTO city SET name = "Åkrehamn", is_visible = 0';
        $this->connection->query($query[0]);
        $this->connection->query($query[1]);
        $this->assertEquals(
            'Åkrehamn',
            $this->cityQueryModel
                ->getCitiesWithSpecialChar()
                ->getCurrent()
                ->getName()
                ->get()
        );
    }
}
