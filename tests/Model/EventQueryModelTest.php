<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\{AbstractEvent, Concert, Festival};
use ruhrpottmetaller\Data\LowLevel\{Date\RmDate, String\RmString};
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\{BandQueryModel,
    Connection,
    CityQueryModel,
    EventQueryModel,
    GigQueryModel,
    VenueQueryModel};

final class EventQueryModelTest extends TestCase
{
    private EventQueryModel $eventQueryModel;
    private \mysqli $databaseConnection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->databaseConnection = Connection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->eventQueryModel = EventQueryModel::new(
            $this->databaseConnection,
            GigQueryModel::new(
                $this->databaseConnection,
                BandQueryModel::new($this->databaseConnection)
            ),
            VenueQueryModel::new(
                $this->databaseConnection,
                CityQueryModel::new($this->databaseConnection)
            )
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE event';
        $query[] = 'TRUNCATE city';
        $query[] = 'TRUNCATE venue';
        $query[] = 'TRUNCATE band';
        $query[] = 'TRUNCATE gig';
        $this->databaseConnection->query($query[0]);
        $this->databaseConnection->query($query[1]);
        $this->databaseConnection->query($query[2]);
        $this->databaseConnection->query($query[3]);
        $this->databaseConnection->query($query[4]);
    }


    /**
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\VenueQueryModel
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
            $this->eventQueryModel->getEventsByMonth(RmDate::new('2022-06'))
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @covers \ruhrpottmetaller\Model\Connection
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\AbstractModel
     */
    public function testArrayShouldContainEntryIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO event SET name = "Beerfest", date_start = "2022-06-11"';
        $this->databaseConnection->query($query);
        $this->assertTrue(
            $this->eventQueryModel->getEventsByMonth(RmDate::new('2022-06'))
                                          ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @covers \ruhrpottmetaller\Model\Connection
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses  \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\AbstractModel
     */
    public function testArrayShouldContainChildOfAbstractEventDatasetIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO event SET name = "Beerfest", date_start = "2022-06-12"';
        $this->databaseConnection->query($query);
        $this->assertInstanceOf(
            AbstractEvent::class,
            $this->eventQueryModel->getEventsByMonth(RmDate::new('2022-06'))
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses  \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testArrayShouldContainQueryFestivalDatasetIfEventLastsMoreThanOneDay(): void
    {
        $query = 'INSERT INTO event SET number_of_days = 2, date_start = "2022-06-01"';
        $this->databaseConnection->query($query);
        $this->assertInstanceOf(
            Festival::class,
            $this->eventQueryModel->getEventsByMonth(RmDate::new('2022-06'))
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses  \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testArrayShouldContainQueryConcertDatasetIfEventLastOneDay(): void
    {
        $query = 'INSERT INTO event SET number_of_days = 1, date_start = "2022-06-29"';
        $this->databaseConnection->query($query);
        $this->assertInstanceOf(
            Concert::class,
            $this->eventQueryModel->getEventsByMonth(RmDate::new('2022-06'))
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses  \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testArrayShouldContainNoEventsFromOtherMonths(): void
    {
        $query = 'INSERT INTO event SET date_start = "2022-07-18"';
        $this->databaseConnection->query($query);
        $this->assertFalse(
            $this->eventQueryModel
                 ->getEventsByMonth(RmDate::new('2022-06'))
                 ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses  \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testQueryConcertDataSetShouldContainNameFromDatabase(): void
    {
        $query = 'INSERT INTO event SET name = "Thrash Attack", date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertEquals(
            'Thrash Attack',
            $this->eventQueryModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses  \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testQueryConcertDataSetShouldContainUrlFromDatabase(): void
    {
        $query = 'INSERT INTO event SET url = "www.rockhard.de", date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertEquals(
            'www.rockhard.de',
            $this->eventQueryModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getUrl()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testQueryConcertDataSetShouldContainSoldOutStatusFromDatabase(): void
    {
        $query = 'INSERT INTO event SET is_sold_out = true, date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertTrue(
            $this->eventQueryModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getIsSoldOut()
                ->isTrue()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses \ruhrpottmetaller\Model\VenueQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses \ruhrpottmetaller\Model\Connection
     */
    public function testQueryConcertDataSetShouldContainCanceledStatusFromDatabase(): void
    {
        $query = 'INSERT INTO event SET is_canceled = true, date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertTrue(
            $this->eventQueryModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getIsCanceled()
                ->isTrue()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testQueryConcertDataSetShouldContainVenueAndCityNameFromDatabase(): void
    {
        $query[] = 'INSERT INTO event SET venue_id = 1, date_start = "2022-06-18"';
        $query[] = 'INSERT INTO venue SET name = "Turock", city_id = 1';
        $query[] = 'INSERT INTO city SET name = "Essen"';
        $this->databaseConnection->query($query[0]);
        $this->databaseConnection->query($query[1]);
        $this->databaseConnection->query($query[2]);
        $this->assertEquals(
            'Turock, Essen',
            $this->eventQueryModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getVenueAndCityName()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses  \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testQueryConcertDataSetShouldContainDateStartAsDateFromDatabase(): void
    {
        $query = 'INSERT INTO event SET date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertEquals(
            '2022-06-18',
            $this->eventQueryModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getDate()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @uses  \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testQueryFestivalDataSetShouldContainDateStartAsDateStartFromDatabase(): void
    {
        $query = 'INSERT INTO event SET number_of_days = 3, date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertEquals(
            '2022-06-18',
            $this->eventQueryModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getDateStart()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testQueryFestivalDataSetShouldContainNumberOfDatesFromDatabase(): void
    {
        $query = 'INSERT INTO event SET number_of_days = 3, date_start = "2022-06-18"';
        $this->databaseConnection->query($query);
        $this->assertEquals(
            3,
            $this->eventQueryModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->getNumberOfDays()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\EventQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses  \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\VenueQueryModel
     * @uses  \ruhrpottmetaller\Model\BandQueryModel
     * @uses  \ruhrpottmetaller\Model\GigQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses   \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses   \ruhrpottmetaller\Data\HighLevel\Festival
     * @uses   \ruhrpottmetaller\Data\HighLevel\Band
     * @uses   \ruhrpottmetaller\Data\HighLevel\Gig
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
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testShouldReturnBands(): void
    {
        $query[] = 'INSERT INTO event SET date_start = "2022-06-18"';
        $query[] = 'INSERT INTO gig SET event_id = 1, band_id = 1';
        $query[] = 'INSERT INTO band SET name = "Houndwolf"';
        $this->databaseConnection->query($query[0]);
        $this->databaseConnection->query($query[1]);
        $this->databaseConnection->query($query[2]);
        $this->assertTrue(
            $this->eventQueryModel
                ->getEventsByMonth(RmDate::new('2022-06'))
                ->getCurrent()
                ->hasCurrentGig()
        );
    }
}
