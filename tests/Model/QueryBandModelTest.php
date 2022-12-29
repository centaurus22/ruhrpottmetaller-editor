<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Model\{Connection, QueryBandModel};
use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;

final class QueryBandModelTest extends TestCase
{
    private QueryBandModel $QueryBandDatabaseModel;
    private \mysqli $DatabaseConnection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->DatabaseConnection = Connection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->QueryBandDatabaseModel = QueryBandModel::new(
            $this->DatabaseConnection,
            RmArray::new()
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE band';
        $this->DatabaseConnection->query($query[0]);
    }


    /**
     * @covers \ruhrpottmetaller\Model\QueryBandModel
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @uses   \ruhrpottmetaller\Model\Connection
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\AbstractRmObject
     */
    public function testShouldReturnDataTypeArray(): void
    {
        $this->assertInstanceOf(
            RmArray::class,
            $this->QueryBandDatabaseModel->getBands()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryBandModel
     * @covers \ruhrpottmetaller\Model\Connection
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\Band
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Model\AbstractModel
     */
    public function testArrayShouldContainEntryIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO band SET name = "Spiker"';
        $this->DatabaseConnection->query($query);
        $this->assertTrue(
            $this->QueryBandDatabaseModel->getBands()
                ->hasCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\QueryBandModel
     * @covers \ruhrpottmetaller\Model\Connection
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\Band
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Model\AbstractModel
     */
    public function testArrayShouldGetCityDatasetIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO band SET name = "Teutonic Slaughter"';
        $this->DatabaseConnection->query($query);
        $this->assertInstanceOf(
            Band::class,
            $this->QueryBandDatabaseModel->getBands()
                                          ->getCurrent()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\QueryBandModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\Band
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testShouldGetBandNameFromDatabase(): void
    {
        $query = 'INSERT INTO band SET name = "Kreator"';
        $this->DatabaseConnection->query($query);
        $this->assertEquals(
            'Kreator',
            $this->QueryBandDatabaseModel
                ->getBands()
                ->getCurrent()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\QueryBandModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\Band
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testShouldGetIdFromDatabase(): void
    {
        $query = 'INSERT INTO band SET name = "Houndwolf"';
        $this->DatabaseConnection->query($query);
        $this->assertEquals(
            '1',
            $this->QueryBandDatabaseModel
                ->getBands()
                ->getCurrent()
                ->getId()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\QueryBandModel
     * @throws \Exception
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\Band
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\RmArray
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\RmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\RmBool
     * @uses   \ruhrpottmetaller\Model\Connection
     */
    public function testShouldGetVisibleStatusFromDatabase(): void
    {
        $query = 'INSERT INTO band SET name = "Custard", is_visible = 0';
        $this->DatabaseConnection->query($query);
        $this->assertEquals(
            '0',
            $this->QueryBandDatabaseModel
                ->getBands()
                ->getCurrent()
                ->getIsVisible()
                ->get()
        );
    }
}
