<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model\Command;

use mysqli;
use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\DatabaseConnection;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;
use ruhrpottmetaller\Model\Command\DatabaseEventCommandModel;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseEventQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseGigQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel;

final class DatabaseEventCommandModelTest extends TestCase
{
    private DatabaseEventQueryModel $queryModel;
    private DatabaseEventCommandModel $commandModel;
    private mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = DatabaseConnection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->queryModel = DatabaseEventQueryModel::new(
            $this->connection,
            DatabaseGigQueryModel::new(
                $this->connection,
                DatabaseBandQueryModel::new($this->connection)
            ),
            DatabaseVenueQueryModel::new(
                $this->connection,
                DatabaseCityQueryModel::new($this->connection)
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
     * @covers \ruhrpottmetaller\Model\Command\DatabaseEventCommandModel
     * @covers \ruhrpottmetaller\Model\Command\DatabaseCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Event
     * @uses \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses DatabaseCityQueryModel
     * @uses DatabaseEventQueryModel
     * @uses DatabaseVenueQueryModel
     * @uses DatabaseBandQueryModel
     * @uses DatabaseGigQueryModel
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
        $this->assertTrue(
            $this->queryModel
                ->getEventsByMonth(RmDate::new('2022-01-01'))
                ->getCurrent()
                ->getIsSoldOut()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\Command\DatabaseEventCommandModel
     * @covers \ruhrpottmetaller\Model\Command\DatabaseCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Event
     * @uses \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses DatabaseCityQueryModel
     * @uses DatabaseEventQueryModel
     * @uses DatabaseVenueQueryModel
     * @uses DatabaseBandQueryModel
     * @uses DatabaseGigQueryModel
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
     * @covers \ruhrpottmetaller\Model\Command\DatabaseEventCommandModel
     * @covers \ruhrpottmetaller\Model\Command\DatabaseCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Event
     * @uses \ruhrpottmetaller\Data\HighLevel\Concert
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses DatabaseCityQueryModel
     * @uses DatabaseEventQueryModel
     * @uses DatabaseVenueQueryModel
     * @uses DatabaseBandQueryModel
     * @uses DatabaseGigQueryModel
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
