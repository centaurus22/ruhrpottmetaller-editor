<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{BandQueryModel,
    Connection,
    CityQueryModel,
    DatabaseEventCommandModel,
    DatabaseEventQueryModel,
    DatabaseGigQueryModel,
    DatabaseVenueQueryModel};

final class EventCommandModelTest extends TestCase
{
    private DatabaseEventQueryModel $queryModel;
    private DatabaseEventCommandModel $commandModel;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = Connection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->queryModel = DatabaseEventQueryModel::new(
            $this->connection,
            DatabaseGigQueryModel::new(
                $this->connection,
                BandQueryModel::new($this->connection)
            ),
            DatabaseVenueQueryModel::new(
                $this->connection,
                CityQueryModel::new($this->connection)
            )
        );
        $this->commandModel = DatabaseEventCommandModel::new(
            $this->connection,
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE event';
        $this->connection->query($query[0]);
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseEventCommandModel
     * @covers \ruhrpottmetaller\Model\DatabaseCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseEventQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     * @uses \ruhrpottmetaller\Model\BandQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseGigQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Data\RmArray
     *
     */

    public function testShouldUpdateSoldOutStatus(): void
    {
        $query = 'INSERT INTO event SET date_start = "2022-01-01"';
        $this->connection->query($query);
        $this->commandModel->setSoldOut(RmInt::new(1));
        $this->assertEquals(
            true,
            $this->queryModel
                ->getEventsByMonth(RmDate::new("2022-01-01"))
                ->getCurrent()
                ->getIsSoldOut()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseEventCommandModel
     * @covers \ruhrpottmetaller\Model\DatabaseCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseEventQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     * @uses \ruhrpottmetaller\Model\BandQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseGigQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Data\RmArray
     *
     */

    public function testShouldDeleteEvent(): void
    {
        $query = 'INSERT INTO event SET date_start = "2022-01-01"';
        $this->connection->query($query);
        $this->commandModel->delete(RmInt::new(1));
        $this->assertFalse(
            $this->queryModel
                ->getEventsByMonth(RmDate::new('2022-01-01'))
                ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseEventCommandModel
     * @covers \ruhrpottmetaller\Model\DatabaseCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseEventQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseVenueQueryModel
     * @uses \ruhrpottmetaller\Model\BandQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseGigQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\RmTrue
     * @uses \ruhrpottmetaller\Data\RmArray
     *
     */

    public function testShouldSetEventAsCanceled(): void
    {
        $query = 'INSERT INTO event SET date_start = "2022-01-01"';
        $this->connection->query($query);
        $this->commandModel->setCanceled(RmInt::new(1));
        $this->assertTrue(
            $this->queryModel
                ->getEventsByMonth(RmDate::new('2022-01-01'))
                ->getCurrent()
                ->getIsCanceled()
                ->isTrue()
        );
    }
}
