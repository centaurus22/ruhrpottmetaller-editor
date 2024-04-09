<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model\Query;

use mysqli;
use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\DatabaseConnection;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;

final class DatabaseBandQueryModelTest extends TestCase
{
    private DatabaseBandQueryModel $QueryBandDatabaseModel;
    private mysqli $DatabaseConnection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->DatabaseConnection = DatabaseConnection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->QueryBandDatabaseModel = DatabaseBandQueryModel::new(
            $this->DatabaseConnection
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE band';
        $this->DatabaseConnection->query($query[0]);
    }


    /**
     * @covers \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @uses \ruhrpottmetaller\Data\HighLevel\Band
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
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
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseConnection
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     */
    public function testArrayShouldContainEntryIfEntryInDatabase(): void
    {
        $query = 'INSERT INTO band SET name = "Spiker"';
        $this->DatabaseConnection->query($query);
        $this->assertTrue($this->QueryBandDatabaseModel->getBands()->hasCurrent());
    }

    /**
     * @covers \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @covers \ruhrpottmetaller\Model\DatabaseConnection
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseModel
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
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
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
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
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
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
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

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldFilterByFirstChar(): void
    {
        $query[] = 'INSERT INTO band SET name = "Custard", is_visible = 0';
        $query[] = 'INSERT INTO band SET name = "Firestorm", is_visible = 0';
        $this->DatabaseConnection->query($query[0]);
        $this->DatabaseConnection->query($query[1]);
        $this->assertEquals(
            'Firestorm',
            $this->QueryBandDatabaseModel
                ->getBandsByFirstChar(RmString::new('F'))
                ->getCurrent()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldFindBandsWhoseNameStartWithASpecialChar(): void
    {
        $query[] = 'INSERT INTO band SET name = "Custard", is_visible = 0';
        $query[] = 'INSERT INTO band SET name = "1349", is_visible = 0';
        $this->DatabaseConnection->query($query[0]);
        $this->DatabaseConnection->query($query[1]);
        $this->assertEquals(
            '1349',
            $this->QueryBandDatabaseModel
                ->getBandsWithSpecialChar()
                ->getCurrent()
                ->getName()
                ->get()
        );
    }


    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldFindBandsWhoseNameStartWithASpecialCharAndNoLowercaseChars(): void
    {
        $query[] = 'INSERT INTO band SET name = "custard", is_visible = 0';
        $query[] = 'INSERT INTO band SET name = "1349", is_visible = 0';
        $this->DatabaseConnection->query($query[0]);
        $this->DatabaseConnection->query($query[1]);
        $this->assertEquals(
            '1349',
            $this->QueryBandDatabaseModel
                ->getBandsWithSpecialChar()
                ->getCurrent()
                ->getName()
                ->get()
        );
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseBandQueryModel
     * @covers \ruhrpottmetaller\Model\Query\DatabaseQueryModel
     * @uses   \ruhrpottmetaller\AbstractRmObject
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
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
     * @uses   \ruhrpottmetaller\Model\DatabaseConnection
     */
    public function testShouldGetBandByBandData(): void
    {
        $query = 'INSERT INTO band SET id = 4, name = "Houndwolf", is_visible = 1';
        $this->DatabaseConnection->query($query);
        $band = Band::new()
            ->setName(RmString::new('Houndwolf'))
            ->setIsVisible(RmBool::new(true));
        $this->assertEquals(
            '4',
            $this->QueryBandDatabaseModel
                ->getBandByBandData($band)
                ->getId()
                ->get()
        );
    }
}
