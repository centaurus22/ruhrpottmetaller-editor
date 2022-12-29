<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{Connection, QueryCityModel, CommandCityModel};

final class CommandCityModelTest extends TestCase
{
    private QueryCityModel $queryModel;
    private CommandCityModel $commandModel;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = Connection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->queryModel = QueryCityModel::new(
            $this->connection,
        );
        $this->commandModel = CommandCityModel::new(
            $this->connection,
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE city';
        $this->connection->query($query[0]);
    }

    /**
     * @covers \ruhrpottmetaller\Model\CommandCityModel
     * @covers \ruhrpottmetaller\AbstractRmObject
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
     */

    public function testShouldUpdateCity(): void
    {
        $query = 'INSERT INTO city SET name = "Dortmund"';
        $this->connection->query($query);
        $this->commandModel->updateCity(
            RmInt::new(1),
            RmString::new('Lünen'),
            RmBool::new(true)
        );
        $this->assertEquals(
            'Lünen',
            $this->queryModel
                ->getCityById(RmInt::new(1))
                ->getName()
        );
    }
}
