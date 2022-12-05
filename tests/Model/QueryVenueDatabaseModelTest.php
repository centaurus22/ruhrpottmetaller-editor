<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\DatabaseConnectHelper;
use ruhrpottmetaller\Model\QueryCityDatabaseModel;
use ruhrpottmetaller\Model\QueryVenueDatabaseModel;

final class QueryVenueDatabaseModelTest extends TestCase
{
    private QueryVenueDatabaseModel $queryVenueDatabaseModel;
    private \mysqli $DatabaseConnection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->DatabaseConnection = DatabaseConnectHelper::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->queryVenueDatabaseModel = QueryVenueDatabaseModel::new(
            $this->DatabaseConnection,
            QueryCityDatabaseModel::new($this->DatabaseConnection)
        );
        $query[1] = 'INSERT INTO city SET name = "Dortmund"';
        $this->DatabaseConnection->query($query[1]);
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE venue';
        $query[] = 'TRUNCATE city';
        $this->DatabaseConnection->query($query[0]);
        $this->DatabaseConnection->query($query[1]);
    }


    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryCityDatabaseModel
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
            $this->queryVenueDatabaseModel->getVenues()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @throws \Exception
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
        $query = 'INSERT INTO venue SET name = "Turock", city_id = 1';
        $this->DatabaseConnection->query($query);
        $this->assertTrue(
            $this->queryVenueDatabaseModel->getVenues()
                ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @throws \Exception
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
    public function testArrayShouldGetVenueDatasetIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO venue SET name = "Don’t Panic", city_id = 1';
        $this->DatabaseConnection->query($query);
        $this->assertInstanceOf(
            Venue::class,
            $this->queryVenueDatabaseModel->getVenues()
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @throws \Exception
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
    public function testShouldGetVenueNameFromDatabase(): void
    {
        $query = 'INSERT INTO venue SET name = "Kulttempel", city_id = 1';
        $this->DatabaseConnection->query($query);
        $this->assertEquals(
            'Kulttempel',
            $this->queryVenueDatabaseModel
                ->getVenues()
                ->getCurrent()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @throws \Exception
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
        $query = 'INSERT INTO venue SET name = "Kultopia", city_id = 1';
        $this->DatabaseConnection->query($query);
        $this->assertEquals(
            '1',
            $this->queryVenueDatabaseModel
                ->getVenues()
                ->getCurrent()
                ->getId()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @throws \Exception
     * @covers \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
        $query = 'INSERT INTO venue SET name = "JunkYard", city_id = 1, is_visible = 0';
        $this->DatabaseConnection->query($query);
        $this->assertEquals(
            '0',
            $this->queryVenueDatabaseModel
                ->getVenues()
                ->getCurrent()
                ->getIsVisible()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @throws \Exception
     * @covers \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
        $query[0] = 'INSERT INTO venue SET name = "JunkYard", city_id = 1, is_visible = 0';
        $this->DatabaseConnection->query($query[0]);
        $this->assertEquals(
            'Dortmund',
            $this->queryVenueDatabaseModel
                ->getVenues()
                ->getCurrent()
                ->getCity()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @throws \Exception
     * @covers \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelDataObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
    public function testShouldGetTwoCityNamesFromDatabase(): void
    {
        $query[0] = 'INSERT INTO venue SET name = "JunkYard", city_id = 1, is_visible = 0';
        $this->DatabaseConnection->query($query[0]);
        $this->assertEquals(
            'Dortmund',
            $this->queryVenueDatabaseModel
                ->getVenues()
                ->getCurrent()
                ->getCity()
                ->getName()
                ->get()
        );
        $query[0] = 'INSERT INTO venue SET name = "JunkYard", city_id = 2, is_visible = 0';
        $query[1] = 'INSERT INTO city SET name = "Hagen"';
        $this->DatabaseConnection->query($query[0]);
        $this->DatabaseConnection->query($query[1]);

        $this->queryVenueDatabaseModel = QueryVenueDatabaseModel::new(
            $this->DatabaseConnection,
            QueryCityDatabaseModel::new($this->DatabaseConnection)
        );
        $this->assertEquals(
            'Hagen',
            $this->queryVenueDatabaseModel
                ->getVenues()
                ->pointAtNext()
                ->getCurrent()
                ->getCity()
                ->getName()
                ->get()
        );
    }
}
