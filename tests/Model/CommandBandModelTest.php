<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{CommandBandModel, Connection, QueryBandModel};

final class CommandBandModelTest extends TestCase
{
    private QueryBandModel $queryModel;
    private CommandBandModel $commandModel;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = Connection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->queryModel = QueryBandModel::new(
            $this->connection,
        );
        $this->commandModel = CommandBandModel::new(
            $this->connection,
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE city';
        $this->connection->query($query[0]);
    }

    /**
     * @covers \ruhrpottmetaller\Model\CommandBandModel
     * @covers \ruhrpottmetaller\Model\AbstractCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\QueryBandModel
     * @uses \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Band
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\AbstractModel
     * @uses \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */

    public function testShouldUpdateBand(): void
    {
        $query = 'INSERT INTO band SET name = "Sabiendas"';
        $this->connection->query($query);
        $band = Band::new()
            ->setId(RmInt::new(1))
            ->setName(RmString::new('Custard'))
            ->setIsVisible(RmBool::new(true));
        $this->commandModel->updateBand($band);
        $this->assertEquals(
            'Custard',
            $this->queryModel
                ->getBandById(RmInt::new(1))
                ->getName()
        );
    }
}
