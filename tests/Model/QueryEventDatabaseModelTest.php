<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\{AbstractEvent, Concert, Festival};
use ruhrpottmetaller\Data\LowLevel\{Date\RmDate, String\RmString};
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\{
    DatabaseConnection,
    QueryCityDatabaseModel,
    QueryEventDatabaseModel,
    QueryVenueDatabaseModel,
};

final class QueryEventDatabaseModelTest extends TestCase
{
    private QueryEventDatabaseModel $QueryEventDatabaseModel;
    private \mysqli $databaseConnection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->databaseConnection = DatabaseConnection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->QueryEventDatabaseModel = QueryEventDatabaseModel::new(
            $this->databaseConnection,
            QueryVenueDatabaseModel::new(
                $this->databaseConnection,
                QueryCityDatabaseModel::new($this->databaseConnection)
            )
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE event';
        $query[] = 'TRUNCATE city';
        $query[] = 'TRUNCATE venue';
        $this->databaseConnection->query($query[0]);
        $this->databaseConnection->query($query[1]);
        $this->databaseConnection->query($query[2]);
    }


    /**
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @throws \Exception
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
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
            $this->QueryEventDatabaseModel->getEventsByMonth(RmDate::new('2022-06'))
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseConnection
     * @throws \Exception
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
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
     * @uses   \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses   \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testArrayShouldContainEntryIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO event SET name = "Beerfest", date_start = "2022-06-11"';
        $this->databaseConnection->query($query);
        $this->assertTrue(
            $this->QueryEventDatabaseModel->getEventsByMonth(RmDate::new('2022-06'))
                                          ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseConnection
     * @uses  \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
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
     * @uses   \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses   \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testArrayShouldContainChildOfAbstractEventDatasetIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO event SET name = "Beerfest", date_start = "2022-06-12"';
        $this->databaseConnection->query($query);
        $this->assertInstanceOf(
            AbstractEvent::class,
            $this->QueryEventDatabaseModel->getEventsByMonth(RmDate::new('2022-06'))
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses   \ruhrpottmetaller\Data\HighLevel\Festival
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
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testArrayShouldContainQueryFestivalDatasetIfEventLastsMoreThanOneDay(): void
    {
        $query = 'INSERT INTO event SET number_of_days = 2, date_start = "2022-06-01"';
        $this->databaseConnection->query($query);
        $this->assertInstanceOf(
            Festival::class,
            $this->QueryEventDatabaseModel->getEventsByMonth(RmDate::new('2022-06'))
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses   \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testArrayShouldContainQueryConcertDatasetIfEventLastOneDay(): void
    {
        $query = 'INSERT INTO event SET number_of_days = 1, date_start = "2022-06-29"';
        $this->databaseConnection->query($query);
        $this->assertInstanceOf(
            Concert::class,
            $this->QueryEventDatabaseModel->getEventsByMonth(RmDate::new('2022-06'))
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testArrayShouldContainNoEventsFromOtherMonths(): void
    {
        $query = 'INSERT INTO event SET date_start = "2022-07-18"';
        $this->databaseConnection->query($query);
        $this->assertFalse(
            $this->QueryEventDatabaseModel
                 ->getEventsByMonth(RmDate::new('2022-06'))
                 ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
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
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testQueryConcertDataSetShouldContainNameFromDatabase(): void
    {
        $query = 'INSERT INTO event SET name = "Thrash Attack", date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertEquals(
            'Thrash Attack',
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
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
     * @uses   \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testQueryConcertDataSetShouldContainUrlFromDatabase(): void
    {
        $query = 'INSERT INTO event SET url = "www.rockhard.de", date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertEquals(
            'www.rockhard.de',
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getUrl()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
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
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testQueryConcertDataSetShouldContainSoldOutStatusFromDatabase(): void
    {
        $query = 'INSERT INTO event SET is_sold_out = true, date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertTrue(
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getIsSoldOut()
                ->isTrue()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\RmArray
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testQueryConcertDataSetShouldContainCanceledStatusFromDatabase(): void
    {
        $query = 'INSERT INTO event SET is_canceled = true, date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertTrue(
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getIsCanceled()
                ->isTrue()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testQueryConcertDataSetShouldContainVenueNameFromDatabase(): void
    {
        $query[] = 'INSERT INTO event SET venue_id = 1, date_start = "2022-06-18"';
        $query[] = 'INSERT INTO venue SET name = "Turock", city_id = 1';
        $query[] = 'INSERT INTO city SET name = "Essen"';
        $this->databaseConnection->query($query[0]);
        $this->databaseConnection->query($query[1]);
        $this->databaseConnection->query($query[2]);
        $this->assertEquals(
            'Turock',
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getVenue()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses   \ruhrpottmetaller\Data\HighLevel\Venue
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
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testQueryConcertDataSetShouldContainCityNameFromDatabase(): void
    {
        $query[] = 'INSERT INTO event SET venue_id = 1, date_start = "2022-06-18"';
        $query[] = 'INSERT INTO venue SET name = "Turock", city_id = 1';
        $query[] = 'INSERT INTO city SET name = "Essen"';
        $this->databaseConnection->query($query[0]);
        $this->databaseConnection->query($query[1]);
        $this->databaseConnection->query($query[2]);
        $this->assertEquals(
            'Essen',
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getVenue()
                ->getCityName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses  \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
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
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testQueryConcertDataSetShouldContainDateStartAsDateFromDatabase(): void
    {
        $query = 'INSERT INTO event SET date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertEquals(
            '2022-06-18',
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getDate()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses   \ruhrpottmetaller\Data\HighLevel\Festival
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
     * @uses   \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testQueryFestivalDataSetShouldContainDateStartAsDateStartFromDatabase(): void
    {
        $query = 'INSERT INTO event SET number_of_days = 3, date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertEquals(
            '2022-06-18',
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getDateStart()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @uses  \ruhrpottmetaller\Model\QueryCityDatabaseModel
     * @uses \ruhrpottmetaller\Model\QueryVenueDatabaseModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses   \ruhrpottmetaller\Data\HighLevel\Festival
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
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testQueryFestivalDataSetShouldContainNumberOfDatesFromDatabase(): void
    {
        $query = 'INSERT INTO event SET number_of_days = 3, date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertEquals(
            3,
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getNumberOfDays()
                ->get()
        );
    }
}
