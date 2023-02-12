<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{Connection, CityQueryModel, CityCommandModel};

final class CityCommandModelTest extends TestCase
{
    private CityQueryModel $queryModel;
    private CityCommandModel $commandModel;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = Connection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->queryModel = CityQueryModel::new(
            $this->connection,
        );
        $this->commandModel = CityCommandModel::new(
            $this->connection,
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE city';
        $this->connection->query($query[0]);
    }

    /**
     * @covers \ruhrpottmetaller\Model\CityCommandModel
     * @covers \ruhrpottmetaller\Model\AbstractCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
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
     * @covers \ruhrpottmetaller\Model\CityCommandModel
     * @covers \ruhrpottmetaller\Model\AbstractCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
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
