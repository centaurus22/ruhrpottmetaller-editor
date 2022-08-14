<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\AbstractEvent;
use ruhrpottmetaller\Data\HighLevel\Concert;
use ruhrpottmetaller\Data\HighLevel\Festival;
use ruhrpottmetaller\Data\LowLevel\RmArray;
use ruhrpottmetaller\Data\LowLevel\RmString;
use ruhrpottmetaller\Model\DatabaseConnectHelper;
use ruhrpottmetaller\Model\QueryEventDatabaseModel;

final class QueryEventDatabaseModelTest extends TestCase
{
    private QueryEventDatabaseModel $QueryEventDatabaseModel;
    private \mysqli $DatabaseConnection;

    public function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->DatabaseConnection = DatabaseConnectHelper::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->QueryEventDatabaseModel = QueryEventDatabaseModel::new(
            $this->DatabaseConnection,
            RmArray::new()
        );
    }

    public function tearDown(): void
    {
        $query[] = 'TRUNCATE event';
        $query[] = 'TRUNCATE city';
        $query[] = 'TRUNCATE venue';
        $this->DatabaseConnection->query($query[0]);
        $this->DatabaseConnection->query($query[1]);
        $this->DatabaseConnection->query($query[2]);
    }


    /**
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     */
    public function testShouldReturnDataTypeArray(): void
    {
        $this->assertInstanceOf(
            RmArray::class,
            $this->QueryEventDatabaseModel->getEventsByMonth(RmString::new('2022-06'))
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testShouldBeInitializedByNew(): void
    {
        $this->assertInstanceOf(
            RmArray::class,
            $this->QueryEventDatabaseModel->getEventsByMonth(RmString::new('2022-06'))
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testArrayShouldContainEntryIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO event SET name = "Beerfest", date_start = "2022-06-11"';
        $this->DatabaseConnection->query($query);
        $this->assertTrue(
            $this->QueryEventDatabaseModel->getEventsByMonth(RmString::new('2022-06'))
                                          ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testArrayShouldContainChildOfAbstractEventDatasetIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO event SET name = "Beerfest", date_start = "2022-06-12"';
        $this->DatabaseConnection->query($query);
        $this->assertInstanceOf(
            AbstractEvent::class,
            $this->QueryEventDatabaseModel->getEventsByMonth(RmString::new('2022-06'))
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testArrayShouldContainQueryFestivalDatasetIfEventLastsMoreThanOneDay(): void
    {
        $query = 'INSERT INTO event SET number_days = 2, date_start = "2022-06-01"';
        $this->DatabaseConnection->query($query);
        $this->assertInstanceOf(
            Festival::class,
            $this->QueryEventDatabaseModel->getEventsByMonth(RmString::new('2022-06'))
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testArrayShouldContainQueryConcertDatasetIfEventLastOneDay(): void
    {
        $query = 'INSERT INTO event SET number_days = 1, date_start = "2022-06-29"';
        $this->DatabaseConnection->query($query);
        $this->assertInstanceOf(
            Concert::class,
            $this->QueryEventDatabaseModel->getEventsByMonth(RmString::new('2022-06'))
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testArrayShouldContainNoEventsFromOtherMonths(): void
    {
        $query = 'INSERT INTO event SET date_start = "2022-07-18"';
        $this->DatabaseConnection->query($query);
        $this->assertFalse(
            $this->QueryEventDatabaseModel
                 ->getEventsByMonth(RmString::new('2022-06'))
                 ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testQueryConcertDataSetShouldContainNameFromDatabase(): void
    {
        $query = 'INSERT INTO event SET name = "Thrash Attack", date_start = "2022-06-18"';
        $this->DatabaseConnection->query($query);
        $this->assertEquals(
            'Thrash Attack',
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmString::new('2022-06'))
                ->getCurrent()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testQueryConcertDataSetShouldContainUrlFromDatabase(): void
    {
        $query = 'INSERT INTO event SET url = "www.rockhard.de", date_start = "2022-06-18"';
        $this->DatabaseConnection->query($query);
        $this->assertEquals(
            'www.rockhard.de',
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmString::new('2022-06'))
                ->getCurrent()
                ->getUrl()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testQueryConcertDataSetShouldContainSoldOutStatusFromDatabase(): void
    {
        $query = 'INSERT INTO event SET is_sold_out = true, date_start = "2022-06-18"';
        $this->DatabaseConnection->query($query);
        $this->assertTrue(
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmString::new('2022-06'))
                ->getCurrent()
                ->getIsSoldOut()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     */
    public function testQueryConcertDataSetShouldContainCanceledStatusFromDatabase(): void
    {
        $query = 'INSERT INTO event SET is_canceled = true, date_start = "2022-06-18"';
        $this->DatabaseConnection->query($query);
        $this->assertTrue(
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmString::new('2022-06'))
                ->getCurrent()
                ->getIsCanceled()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testQueryConcertDataSetShouldContainVenueNameFromDatabase(): void
    {
        $query[] = 'INSERT INTO event SET venue_id = 1, date_start = "2022-06-18"';
        $query[] = 'INSERT INTO venue SET name = "Turock", city_id = 1';
        $this->DatabaseConnection->query($query[0]);
        $this->DatabaseConnection->query($query[1]);
        $this->assertEquals(
            'Turock',
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmString::new('2022-06'))
                ->getCurrent()
                ->getVenueName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     */
    public function testQueryConcertDataSetShouldContainCityNameFromDatabase(): void
    {
        $query[] = 'INSERT INTO event SET venue_id = 1, date_start = "2022-06-18"';
        $query[] = 'INSERT INTO venue SET name = "Turock", city_id = 1';
        $query[] = 'INSERT INTO city SET name = "Essen"';
        $this->DatabaseConnection->query($query[0]);
        $this->DatabaseConnection->query($query[1]);
        $this->DatabaseConnection->query($query[2]);
        $this->assertEquals(
            'Essen',
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmString::new('2022-06'))
                ->getCurrent()
                ->getCityName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Concert
     */
    public function testQueryConcertDataSetShouldContainDateStartAsDateFromDatabase(): void
    {
        $query = 'INSERT INTO event SET date_start = "2022-06-18"';
        $this->DatabaseConnection->query($query);
        $this->assertEquals(
            '2022-06-18',
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmString::new('2022-06'))
                ->getCurrent()
                ->getDate()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     */
    public function testQueryFestivalDataSetShouldContainDateStartAsDateStartFromDatabase(): void
    {
        $query = 'INSERT INTO event SET number_days = 3, date_start = "2022-06-18"';
        $this->DatabaseConnection->query($query);
        $Events = $this->QueryEventDatabaseModel->getEventsByMonth(RmString::new('2022-06'));
        $this->assertEquals(
            '2022-06-18',
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmString::new('2022-06'))
                ->getCurrent()
                ->getDateStart()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryEventDatabaseModel
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractRmValue
     * @covers \ruhrpottmetaller\Data\LowLevel\RmArray
     * @covers \ruhrpottmetaller\Data\LowLevel\RmString
     * @covers \ruhrpottmetaller\Data\LowLevel\RmInt
     * @covers \ruhrpottmetaller\Data\LowLevel\RmBool
     * @covers \ruhrpottmetaller\Data\LowLevel\RmDate
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Model\AbstractDatabaseModel
     * @covers \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @covers \ruhrpottmetaller\Data\HighLevel\Festival
     */
    public function testQueryFestivalDataSetShouldContainNumberOfDatesFromDatabase(): void
    {
        $query = 'INSERT INTO event SET number_days = 3, date_start = "2022-06-18"';
        $this->DatabaseConnection->query($query);
        $this->assertEquals(
            3,
            $this->QueryEventDatabaseModel
                ->getEventsByMonth(RmString::new('2022-06'))
                ->getCurrent()
                ->getNumberOfDays()
                ->get()
        );
    }
}
