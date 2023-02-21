<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\{BandQueryModel, Connection, GigQueryModel};

final class GigQueryModelTest extends TestCase
{
    private GigQueryModel $gigQueryModel;
    private \mysqli $connection;

    protected function setUp(): void
    {
        $ConnectionInformationFile = RmString::new('tests/Model/databaseConfig.inc.php');
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->connection = Connection::new($ConnectionInformationFile)
                ->connect()
                ->getConnection();
        $this->gigQueryModel = GigQueryModel::new(
            $this->connection,
            BandQueryModel::new($this->connection)
        );
    }

    protected function tearDown(): void
    {
        $query[] = 'TRUNCATE gig';
        $query[] = 'TRUNCATE band';
        $this->connection->query($query[0]);
        $this->connection->query($query[1]);
    }


    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\gigQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses \ruhrpottmetaller\Model\BandQueryModel
     * @uses   \ruhrpottmetaller\Model\Connection
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\City
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\RmArray
     */
    public function testShouldReturnDataTypeArray(): void
    {
        $this->assertInstanceOf(
            RmArray::class,
            $this->gigQueryModel->getGigsByEventId(RmInt::new(1))
        );
    }

    /**
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Model\gigQueryModel
     * @covers \ruhrpottmetaller\Model\AbstractModel
     * @covers \ruhrpottmetaller\Model\AbstractQueryModel
     * @uses \ruhrpottmetaller\Model\BandQueryModel
     * @uses   \ruhrpottmetaller\Model\Connection
     * @uses   \ruhrpottmetaller\Data\HighLevel\AbstractNamedHighLevelData
     * @uses   \ruhrpottmetaller\Data\HighLevel\Gig
     * @uses   \ruhrpottmetaller\Data\HighLevel\Band
     * @uses   \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses   \ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses   \ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool
     * @uses   \ruhrpottmetaller\Data\LowLevel\Date\RmDate
     * @uses   \ruhrpottmetaller\Data\RmArray
     */
    public function testShouldReturnArrayWithOneGig(): void
    {
        $query[] = 'TRUNCATE gig';
        $query[] = 'TRUNCATE band';
        $query[] = "INSERT INTO gig SET
                    id = 1,
                    event_id = 1,
                    band_id = 1,
                    additional_information = 'Gibt Freibier'";
        $query[] = "INSERT INTO band SET NAME = 'Imparity'";
        $this->connection->query($query[0]);
        $this->connection->query($query[1]);
        $this->connection->query($query[2]);
        $this->connection->query($query[3]);
        $this->assertTrue(
            $this
                ->gigQueryModel
                ->getGigsByEventId(RmInt::new(1))
                ->hasCurrent()
        );
        $this->assertEquals(
            'Gibt Freibier',
            $this
                ->gigQueryModel
                ->getGigsByEventId(RmInt::new(1))
                ->getCurrent()
                ->getAdditionalInformation()
        );
        $this->assertEquals(
            'Imparity',
            $this
                ->gigQueryModel
                ->getGigsByEventId(RmInt::new(1))
                ->getCurrent()
                ->getBandName()
        );
    }
}
