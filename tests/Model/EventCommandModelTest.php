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
    EventCommandModel,
    EventQueryModel,
    GigQueryModel,
    VenueQueryModel};

final class EventCommandModelTest extends TestCase
{
    private EventQueryModel $queryModel;
    private EventCommandModel $commandModel;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = Connection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->queryModel = EventQueryModel::new(
            $this->connection,
            GigQueryModel::new(
                $this->connection,
                BandQueryModel::new($this->connection)
            ),
            VenueQueryModel::new(
                $this->connection,
                CityQueryModel::new($this->connection)
            )
        );
        $this->commandModel = EventCommandModel::new(
            $this->connection,
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE event';
        $this->connection->query($query[0]);
    }

    /**
     * @covers \ruhrpottmetaller\Model\EventCommandModel
     * @covers \ruhrpottmetaller\Model\AbstractCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractEvent
     * @uses \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\AbstractModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\EventQueryModel
     * @uses \ruhrpottmetaller\Model\VenueQueryModel
     * @uses \ruhrpottmetaller\Model\BandQueryModel
     * @uses \ruhrpottmetaller\Model\GigQueryModel
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
}
