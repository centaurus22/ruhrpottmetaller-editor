<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\DatabaseConnectHelper;
use ruhrpottmetaller\Model\QueryCityDatabaseModel;

final class QueryCityDatabaseModelTest extends TestCase
{
    private QueryCityDatabaseModel $QueryCityDatabaseModel;
    private \mysqli $DatabaseConnection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->DatabaseConnection = DatabaseConnectHelper::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->QueryCityDatabaseModel = QueryCityDatabaseModel::new(
            $this->DatabaseConnection,
            RmArray::new()
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE city';
        $this->DatabaseConnection->query($query[0]);
    }


    /**
     * @covers \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @throws \Exception
     * @uses   \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
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
            $this->QueryCityDatabaseModel->getCities()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @throws \Exception
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testArrayShouldContainEntryIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Dortmund"';
        $this->DatabaseConnection->query($query);
        $this->assertTrue(
            $this->QueryCityDatabaseModel->getCities()
                ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @throws \Exception
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testArrayShouldGetCityDatasetIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Essen"';
        $this->DatabaseConnection->query($query);
        $this->assertInstanceOf(
            City::class,
            $this->QueryCityDatabaseModel->getCities()
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @throws \Exception
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Model\DatabaseConnectHelper
     */
    public function testShouldGetCityNameFromDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Mülheim an der Ruhr"';
        $this->DatabaseConnection->query($query);
        $this->assertEquals(
            'Mülheim an der Ruhr',
            $this->QueryCityDatabaseModel
                ->getCities()
                ->getCurrent()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @throws \Exception
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Model\DatabaseConnectHelper
     */
    public function testShouldGetIdFromDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Mülheim an der Ruhr"';
        $this->DatabaseConnection->query($query);
        $this->assertEquals(
            '1',
            $this->QueryCityDatabaseModel
                ->getCities()
                ->getCurrent()
                ->getId()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @throws \Exception
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Model\DatabaseConnectHelper
     */
    public function testShouldGetVisibleStatusFromDatabase(): void
    {
        $query = 'INSERT INTO city SET name = "Mülheim an der Ruhr", is_visible = 0';
        $this->DatabaseConnection->query($query);
        $this->assertEquals(
            '0',
            $this->QueryCityDatabaseModel
                ->getCities()
                ->getCurrent()
                ->getIsVisible()
                ->get()
        );
    }
}
