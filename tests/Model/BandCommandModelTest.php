<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\{DatabaseBandCommandModel, DatabaseConnection, DatabaseBandQueryModel};

final class BandCommandModelTest extends TestCase
{
    private DatabaseBandQueryModel $queryModel;
    private DatabaseBandCommandModel $commandModel;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = DatabaseConnection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->queryModel = DatabaseBandQueryModel::new(
            $this->connection,
        );
        $this->commandModel = DatabaseBandCommandModel::new(
            $this->connection,
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE city';
        $this->connection->query($query[0]);
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseBandCommandModel
     * @covers \ruhrpottmetaller\Model\DatabaseCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\DatabaseBandQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Band
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
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
        $this->commandModel->replaceData($band);
        $this->assertEquals(
            'Custard',
            $this->queryModel
                ->getBandById(RmInt::new(1))
                ->getName()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseBandCommandModel
     * @covers \ruhrpottmetaller\Model\DatabaseCommandModel
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\DatabaseBandQueryModel
     * @uses \ruhrpottmetaller\Model\DatabaseQueryModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Band
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Data\LowLevel\NotNullBehaviour
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     */

    public function testShouldAddBand(): void
    {
        $band = Band::new()
            ->setName(RmString::new('Fairytale'))
            ->setIsVisible(RmBool::new(true));
        $this->commandModel->addBand($band);
        $this->assertEquals(
            'Fairytale',
            $this->queryModel
                ->getBandByBandData($band)
                ->getName()
        );
    }
}
