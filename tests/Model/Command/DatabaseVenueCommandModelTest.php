<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model\Command;

use mysqli;
use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\DatabaseConnection;
use ruhrpottmetaller\Model\Command\DatabaseVenueCommandModel;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;
use ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel;

final class DatabaseVenueCommandModelTest extends TestCase
{
    private DatabaseVenueQueryModel $queryModel;
    private DatabaseVenueCommandModel $commandModel;
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
        $this->commandModel = DatabaseVenueCommandModel::new($this->connection);
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE venue';
        $this->connection->query($query[0]);
    }

    /**
     * @covers \ruhrpottmetaller\Model\Command\DatabaseVenueCommandModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @covers \ruhrpottmetaller\Model\Command\DatabaseCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\IsNullBehaviour
     */

    public function testShouldAddVenue(): void
    {
        $query = 'INSERT INTO city SET name = "Marl"';
        $this->connection->query($query);
        $city = City::new()
            ->setId(RmInt::new(1));
        $venue = Venue::new()
            ->setName(RmString::new('Lükaz'))
            ->setCity($city)
            ->setUrlDefault(RmString::new('null'))
            ->setIsVisible(RmBool::new(true));
        $this->commandModel->addVenue($venue);
        $this->assertEquals(
            'Lükaz',
            $this->queryModel
                ->getVenueById(RmInt::new(1))
                ->getName()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\Command\DatabaseVenueCommandModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @covers \ruhrpottmetaller\Model\Command\DatabaseCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
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
        $this->commandModel->replaceData($venue);
        $this->assertEquals(
            'Lükaz',
            $this->queryModel
                ->getVenueById(RmInt::new(1))
                ->getName()
        );
    }
}
