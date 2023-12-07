<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller\Command;

use mysqli;
use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\Command\AbstractCommandController;
use ruhrpottmetaller\Controller\Command\Ordinary\GeneralCommandController;
use ruhrpottmetaller\Data\HighLevel\{Band, City, Venue};
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{Command\DatabaseCityCommandModel, Query\DatabaseCityQueryModel};
use ruhrpottmetaller\Model\{Command\DatabaseBandCommandModel, Query\DatabaseBandQueryModel};
use ruhrpottmetaller\Model\{Command\DatabaseVenueCommandModel, Query\DatabaseVenueQueryModel};
use ruhrpottmetaller\Model\DatabaseConnection;

final class GeneralCommandControllerTest extends TestCase
{
    private mysqli $connection;
    private AbstractCommandController $commandController;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = DatabaseConnection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Command\AbstractCommandController
     * @covers \ruhrpottmetaller\Controller\Command\Ordinary\GeneralCommandController
     * @uses \ruhrpottmetaller\Model\Command\DatabaseCityCommandModel
     * @uses \ruhrpottmetaller\Model\Command\DatabaseCommandModel
     * @uses \ruhrpottmetaller\Model\Query\DatabaseQueryModel
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
     */

    public function testShouldUpdateCityName(): void
    {
        $query = 'INSERT INTO city SET name = "Dortmund"';
        $this->connection->query($query);
        $commandModel = DatabaseCityCommandModel::new($this->connection);
        $queryModel = DatabaseCityQueryModel::new($this->connection);
        $city = City::new()
            ->setId(RmInt::new(1))
            ->setName(RmString::new('Lünen'))
            ->setIsVisible(RmBool::new(true));
        $this->commandController = GeneralCommandController::new(
            $commandModel,
            $city
        );
        $this->commandController->execute();
        $this->assertEquals(
            'Lünen',
            $queryModel
                ->getCityById(RmInt::new(1))
                ->getName()
        );

        $query = 'TRUNCATE city';
        $this->connection->query($query);
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Command\AbstractCommandController
     * @covers \ruhrpottmetaller\Controller\Command\Ordinary\GeneralCommandController
     * @uses \ruhrpottmetaller\Model\Command\DatabaseBandCommandModel
     * @uses \ruhrpottmetaller\Model\Command\DatabaseCommandModel
     * @uses \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Band
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */

    public function testShouldUpdateBandName(): void
    {
        $query = 'INSERT INTO band SET name = "Mad Butcher"';
        $this->connection->query($query);
        $queryModel = DatabaseBandQueryModel::new($this->connection);
        $commandModel = DatabaseBandCommandModel::new($this->connection);
        $data = Band::new()
            ->setId(RmInt::new(1))
            ->setName(RmString::new('Kreator'))
            ->setIsVisible(RmBool::new(true));
        $commandController = GeneralCommandController::new(
            $commandModel,
            $data
        );
        $commandController->execute();
        $this->assertEquals(
            'Kreator',
            $queryModel
                ->getBandById(RmInt::new(1))
                ->getName()
        );

        $query = 'TRUNCATE band';
        $this->connection->query($query);
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Command\AbstractCommandController
     * @covers \ruhrpottmetaller\Controller\Command\Ordinary\GeneralCommandController
     * @uses \ruhrpottmetaller\Model\Command\DatabaseVenueCommandModel
     * @uses \ruhrpottmetaller\Model\Command\DatabaseCityCommandModel
     * @uses \ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel
     * @uses \ruhrpottmetaller\Model\Query\DatabaseCityQueryModel
     * @uses \ruhrpottmetaller\Model\Command\DatabaseCommandModel
     * @uses \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */

    public function testShouldUpdateVenueName(): void
    {
        $query = 'INSERT INTO venue SET name = "Parkhaus", city_id = 1';
        $this->connection->query($query);
        $query = 'INSERT INTO city SET name = "Duisburg"';
        $this->connection->query($query);
        $queryModel = DatabaseVenueQueryModel::new(
            $this->connection,
            DatabaseCityQueryModel::new($this->connection)
        );
        $commandModel = DatabaseVenueCommandModel::new($this->connection);
        $city = City::new()->setId(RmInt::new(1));
        $data = Venue::new()
            ->setId(RmInt::new(1))
            ->setName(RmString::new('Kultopia'))
            ->setCity($city)
            ->setUrlDefault(RmString::new(''))
            ->setIsVisible(RmBool::new(true));
        $commandController = GeneralCommandController::new(
            $commandModel,
            $data
        );
        $commandController->execute();
        $this->assertEquals(
            'Kultopia',
            $queryModel
                ->getVenueById(RmInt::new(1))
                ->getName()
        );

        $query = 'TRUNCATE band';
        $this->connection->query($query);
    }
}
