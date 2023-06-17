<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{DatabaseConnection, DatabaseCityQueryModel, DatabaseCityCommandModel};

final class DatabaseCityCommandModelTest extends TestCase
{
    private DatabaseCityQueryModel $queryModel;
    private DatabaseCityCommandModel $commandModel;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = DatabaseConnection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->queryModel = DatabaseCityQueryModel::new(
            $this->connection,
        );
        $this->commandModel = DatabaseCityCommandModel::new(
            $this->connection,
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE city';
        $this->connection->query($query[0]);
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseCityCommandModel
     * @covers \ruhrpottmetaller\Model\DatabaseCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */

    public function testShouldUpdateCityName(): void
    {
        $query = 'INSERT INTO city SET name = "Dortmund"';
        $this->connection->query($query);
        $city = City::new()
            ->setId(RmInt::new(1))
            ->setName(RmString::new('Lünen'))
            ->setIsVisible(RmBool::new(true));
        $this->commandModel->replaceData($city);
        $this->assertEquals(
            'Lünen',
            $this->queryModel
                ->getCityById(RmInt::new(1))
                ->getName()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseCityCommandModel
     * @covers \ruhrpottmetaller\Model\DatabaseCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\City
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Model\DatabaseCityQueryModel
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */

    public function testShouldAddCity(): void
    {
        $city = City::new()
            ->setId(RmInt::new(1))
            ->setName(RmString::new('Lünen'))
            ->setIsVisible(RmBool::new(true));
        $this->commandModel->addCity($city);
        $this->assertEquals(
            'Lünen',
            $this->queryModel
                ->getCityById(RmInt::new(1))
                ->getName()
        );
    }
}
