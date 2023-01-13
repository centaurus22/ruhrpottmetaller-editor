<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\NullVenue;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\{String\RmString, Int\RmInt};
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\{
    Connection,
    CityQueryModel,
    VenueQueryModel
};

final class VenueQueryModelTest extends TestCase
{
    private VenueQueryModel $queryVenueDatabaseModel;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = Connection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->queryVenueDatabaseModel = VenueQueryModel::new(
            $this->connection,
            CityQueryModel::new($this->connection)
        );
        $query[1] = 'INSERT INTO city SET name = "Dortmund"';
        $this->connection->query($query[1]);
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE venue';
        $query[] = 'TRUNCATE city';
        $this->connection->query($query[0]);
        $this->connection->query($query[1]);
    }


    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\VenueQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
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
            $this->queryVenueDatabaseModel->getVenues()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @covers \ruhrpottmetaller\Model\VenueQueryModel
     * @covers \ruhrpottmetaller\Model\Connection
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
     * @uses   \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testArrayShouldContainEntryIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO venue SET name = "Turock", city_id = 1';
        $this->connection->query($query);
        $this->assertTrue(
            $this->queryVenueDatabaseModel->getVenues()
                ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @covers \ruhrpottmetaller\Model\VenueQueryModel
     * @covers \ruhrpottmetaller\Model\Connection
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses   \ruhrpottmetaller\Model\AbstractModel
     */
    public function testArrayShouldGetVenueDatasetIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO venue SET name = "Don’t Panic", city_id = 1';
        $this->connection->query($query);
        $this->assertInstanceOf(
            Venue::class,
            $this->queryVenueDatabaseModel->getVenues()
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @covers \ruhrpottmetaller\Model\VenueQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
    public function testShouldGetVenueNameFromDatabase(): void
    {
        $query = 'INSERT INTO venue SET name = "Kulttempel", city_id = 1';
        $this->connection->query($query);
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
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @covers \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
    public function testShouldGetIdFromDatabase(): void
    {
        $query = 'INSERT INTO venue SET name = "Kultopia", city_id = 1';
        $this->connection->query($query);
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
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\VenueQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @covers \ruhrpottmetaller\Model\CityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
    public function testShouldGetVisibleStatusFromDatabase(): void
    {
        $query = 'INSERT INTO venue SET name = "JunkYard", city_id = 1, is_visible = 0';
        $this->connection->query($query);
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
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @covers \ruhrpottmetaller\Model\VenueQueryModel
     * @covers \ruhrpottmetaller\Model\CityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
    public function testShouldGetCityNameFromDatabase(): void
    {
        $query[0] = 'INSERT INTO venue SET name = "JunkYard", city_id = 1, is_visible = 0';
        $this->connection->query($query[0]);
        $this->assertEquals(
            'Dortmund',
            $this->queryVenueDatabaseModel
                ->getVenues()
                ->getCurrent()
                ->getCityName()
                ->get()
        );
    }


    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @covers \ruhrpottmetaller\Model\VenueQueryModel
     * @covers \ruhrpottmetaller\Model\CityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
    public function testShouldGetDefaultUrlFromDatabase(): void
    {
        $query[0] = 'INSERT INTO venue SET
                      name = "JunkYard",
                      city_id = 1,
                      url_default = "https://junkyard.ruhr"';
        $this->connection->query($query[0]);
        $this->assertEquals(
            'https://junkyard.ruhr',
            $this->queryVenueDatabaseModel
                ->getVenues()
                ->getCurrent()
                ->getUrlDefault()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\VenueQueryModel
     * @covers \ruhrpottmetaller\Model\CityQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
    public function testShouldGetTwoCityNamesFromDatabase(): void
    {
        $query[0] = 'INSERT INTO venue SET name = "JunkYard", city_id = 1, is_visible = 0';
        $this->connection->query($query[0]);
        $this->assertEquals(
            'Dortmund',
            $this->queryVenueDatabaseModel
                ->getVenues()
                ->getCurrent()
                ->getCityName()
                ->get()
        );

        $query[0] = 'INSERT INTO venue SET name = "JunkYard", city_id = 2, is_visible = 0';
        $query[1] = 'INSERT INTO city SET name = "Hagen"';
        $this->connection->query($query[0]);
        $this->connection->query($query[1]);

        $this->queryVenueDatabaseModel = VenueQueryModel::new(
            $this->connection,
            CityQueryModel::new($this->connection)
        );
        $this->assertEquals(
            'Hagen',
            $this->queryVenueDatabaseModel
                ->getVenues()
                ->pointAtNext()
                ->getCurrent()
                ->getCityName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\VenueQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */
    public function testShouldGetNullVenue(): void
    {
        $this->assertInstanceOf(
            NullVenue::class,
            $this->queryVenueDatabaseModel->getVenueById(RmInt::new(null))
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\VenueQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses  \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses  \ruhrpottmetaller\Data\HighLevel\City
     * @uses  \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldGetVenueById(): void
    {
        $query = 'INSERT INTO venue SET name = "JunkYard", city_id = 1';
        $this->connection->query($query);
        $query = 'INSERT INTO city SET name = "Hagen"';
        $this->connection->query($query);
        $this->assertInstanceOf(
            Venue::class,
            $this->queryVenueDatabaseModel->getVenueById(RmInt::new(1))
        );
    }
}
