<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{Connection, QueryCityModel, QueryVenueModel, CommandVenueModel};

final class CommandVenueModelTest extends TestCase
{
    private QueryVenueModel $queryModel;
    private CommandVenueModel $commandModel;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = Connection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->queryModel = QueryVenueModel::new(
            $this->connection,
            QueryCityModel::new($this->connection)
        );
        $this->commandModel = CommandVenueModel::new($this->connection);
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE venue';
        $this->connection->query($query[0]);
    }

    /**
     * @covers \ruhrpottmetaller\Model\CommandVenueModel
     * @covers \ruhrpottmetaller\Model\QueryVenueModel
     * @covers \ruhrpottmetaller\Model\AbstractCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\AbstractModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Model\QueryCityModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */

    public function testShouldUpdateVenue(): void
    {
        $query = 'INSERT INTO venue SET name = "Altstadtschmiede", city_id = 1';
        $this->connection->query($query);
        $query = 'INSERT INTO city SET name = "Recklinghausen"';
        $this->connection->query($query);
        $venue = Venue::new()
            ->setId(RmInt::new(1))
            ->setName(RmString::new('Lükaz'))
            ->setUrlDefault(RmString::new('null'))
            ->setIsVisible(RmBool::new(true));
        $this->commandModel->updateVenue($venue);
        $this->assertEquals(
            'Lükaz',
            $this->queryModel
                ->getVenueById(RmInt::new(1))
                ->getName()
        );
    }
}
