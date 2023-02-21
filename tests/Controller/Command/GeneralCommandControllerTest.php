<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Controller\Command;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Controller\Command\GeneralCommandController;
use ruhrpottmetaller\Data\HighLevel\{Band, City, Venue};
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{CityCommandModel, CityQueryModel};
use ruhrpottmetaller\Model\{BandCommandModel, BandQueryModel};
use ruhrpottmetaller\Model\{VenueCommandModel, VenueQueryModel};
use ruhrpottmetaller\Model\Connection;

final class GeneralCommandControllerTest extends TestCase
{
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = Connection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Controller\Command\AbstractCommandController
     * @covers \ruhrpottmetaller\Controller\Command\GeneralCommandController
     * @uses \ruhrpottmetaller\Model\CityCommandModel
     * @uses \ruhrpottmetaller\Model\AbstractCommandModel
     * @uses \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\AbstractModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */

    public function testShouldUpdateCityName(): void
    {
        $query = 'INSERT INTO city SET name = "Dortmund"';
        $this->connection->query($query);
        $commandModel = CityCommandModel::new($this->connection);
        $queryModel = CityQueryModel::new($this->connection);
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
     * @covers \ruhrpottmetaller\Controller\Command\GeneralCommandController
     * @uses \ruhrpottmetaller\Model\BandCommandModel
     * @uses \ruhrpottmetaller\Model\AbstractCommandModel
     * @uses \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Band
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\AbstractModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Model\BandQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */

    public function testShouldUpdateBandName(): void
    {
        $query = 'INSERT INTO band SET name = "Mad Butcher"';
        $this->connection->query($query);
        $queryModel = BandQueryModel::new($this->connection);
        $commandModel = BandCommandModel::new($this->connection);
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
     * @covers \ruhrpottmetaller\Controller\Command\GeneralCommandController
     * @uses \ruhrpottmetaller\Model\VenueCommandModel
     * @uses \ruhrpottmetaller\Model\CityCommandModel
     * @uses \ruhrpottmetaller\Model\VenueQueryModel
     * @uses \ruhrpottmetaller\Model\CityQueryModel
     * @uses \ruhrpottmetaller\Model\AbstractCommandModel
     * @uses \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Venue
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\AbstractModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Model\BandQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */

    public function testShouldUpdateVenueName(): void
    {
        $query = 'INSERT INTO venue SET name = "Parkhaus", city_id = 1';
        $this->connection->query($query);
        $query = 'INSERT INTO city SET name = "Duisburg"';
        $this->connection->query($query);
        $queryModel = VenueQueryModel::new(
            $this->connection,
            CityQueryModel::new($this->connection)
        );
        $commandModel = VenueCommandModel::new($this->connection);
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
