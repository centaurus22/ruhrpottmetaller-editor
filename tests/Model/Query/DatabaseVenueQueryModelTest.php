<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model\Query;

use mysqli;
use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\NullVenue;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\{Bool\RmBool, Int\RmInt, String\RmString};
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\Command\DatabaseCityCommandModel;
use ruhrpottmetaller\Model\Command\DatabaseVenueCommandModel;
use ruhrpottmetaller\Model\DatabaseConnection;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel;

final class DatabaseVenueQueryModelTest extends TestCase
{
    private DatabaseVenueQueryModel $queryModel;
    private mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = DatabaseConnection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->queryModel = DatabaseVenueQueryModel::new(
            $this->connection,
            DatabaseCityQueryModel::new($this->connection)
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
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
            $this->queryModel->getVenues()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseConnection
     * @uses  \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseModel
     * @uses   \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testArrayShouldContainEntryIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO venue SET name = "Turock", city_id = 1';
        $this->connection->query($query);
        $this->assertTrue(
            $this->queryModel->getVenues()
                ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseConnection
     * @uses  \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseModel
     */
    public function testArrayShouldGetVenueDatasetIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO venue SET name = "Don’t Panic", city_id = 1';
        $this->connection->query($query);
        $this->assertInstanceOf(
            Venue::class,
            $this->queryModel->getVenues()
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @uses \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldGetVenueNameFromDatabase(): void
    {
        $query = 'INSERT INTO venue SET name = "Kulttempel", city_id = 1';
        $this->connection->query($query);
        $this->assertEquals(
            'Kulttempel',
            $this->queryModel
                ->getVenues()
                ->getCurrent()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @uses  \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldGetIdFromDatabase(): void
    {
        $query = 'INSERT INTO venue SET name = "Kultopia", city_id = 1';
        $this->connection->query($query);
        $this->assertEquals(
            '1',
            $this->queryModel
                ->getVenues()
                ->getCurrent()
                ->getId()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldGetVisibleStatusFromDatabase(): void
    {
        $query = 'INSERT INTO venue SET name = "JunkYard", city_id = 1, is_visible = 0';
        $this->connection->query($query);
        $this->assertEquals(
            '0',
            $this->queryModel
                ->getVenues()
                ->getCurrent()
                ->getIsVisible()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldGetCityNameFromDatabase(): void
    {
        $query[0] = 'INSERT INTO venue SET name = "JunkYard", city_id = 1, is_visible = 0';
        $this->connection->query($query[0]);
        $this->assertEquals(
            'Dortmund',
            $this->queryModel
                ->getVenues()
                ->getCurrent()
                ->getCityName()
                ->get()
        );
    }


    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
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
            $this->queryModel
                ->getVenues()
                ->getCurrent()
                ->getUrlDefault()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldGetTwoCityNamesFromDatabase(): void
    {
        $query[0] = 'INSERT INTO venue SET name = "JunkYard", city_id = 1, is_visible = 0';
        $this->connection->query($query[0]);
        $this->assertEquals(
            'Dortmund',
            $this->queryModel
                ->getVenues()
                ->getCurrent()
                ->getCityName()
                ->get()
        );

        $query[0] = 'INSERT INTO venue SET name = "JunkYard", city_id = 2, is_visible = 0';
        $query[1] = 'INSERT INTO city SET name = "Hagen"';
        $this->connection->query($query[0]);
        $this->connection->query($query[1]);

        $this->queryModel = DatabaseVenueQueryModel::new(
            $this->connection,
            DatabaseCityQueryModel::new($this->connection)
        );
        $this->assertEquals(
            'Hagen',
            $this->queryModel
                ->getVenues()
                ->pointAtNext()
                ->getCurrent()
                ->getCityName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @uses \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
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
            $this->queryModel->getVenueById(RmInt::new(null))
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses  \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses  \ruhrpottmetaller\Data\HighLevel\City
     * @uses  \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
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
            $this->queryModel->getVenueById(RmInt::new(1))
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses  \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses  \ruhrpottmetaller\Data\HighLevel\City
     * @uses  \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldGetVenuesByCityName(): void
    {
        $query[] = 'INSERT INTO city SET name = "Essen"';
        $query[] = 'INSERT INTO venue SET name = "Café Nord", city_id = 2';
        $query[] = 'INSERT INTO venue SET name = "JunkYard", city_id = 1';

        for ($n = 0; $n < 3; $n++) {
            $this->connection->query($query[$n]);
        }
        $this->assertEquals(
            'Café Nord',
            $this->queryModel
                ->getVenuesByCityName(RmString::new('Essen'))
                ->getCurrent()
                ->getName()
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses  \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses  \ruhrpottmetaller\Data\HighLevel\City
     * @uses  \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses \ruhrpottmetaller\Model\Command\DatabaseCommandModel
     * @uses \ruhrpottmetaller\Model\Command\DatabaseVenueCommandModel
     * @uses \ruhrpottmetaller\Model\Command\DatabaseCityCommandModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     */
    public function testShouldGetVenueByVenueData(): void
    {
        $city = City::new()
            ->setId(RmInt::new(2))
            ->setName(RmString::new('Bielefeld'))
            ->setIsVisible(RmBool::new(true));
        $cityCommandModel = DatabaseCityCommandModel::new($this->connection);
        $cityCommandModel->addCity($city);

        $venue = Venue::new()
            ->setName(RmString::new('Bier'))
            ->setCity($city)
            ->setUrlDefault(RmString::new(null))
            ->setIsVisible(RmBool::new(true));
        $venueCommandModel = DatabaseVenueCommandModel::new($this->connection);
        $venueCommandModel->addVenue($venue);
        $this->assertEquals(
            1,
            $this->queryModel
                ->getVenueByVenueData($venue)
                ->getId()
                ->get()
        );
    }
}
