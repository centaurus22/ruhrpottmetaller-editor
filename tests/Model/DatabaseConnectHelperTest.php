<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\DataTypeString;
use ruhrpottmetaller\Model\DatabaseConnectHelper;

final class DatabaseConnectHelperTest extends TestCase
{
    private DatabaseConnectHelper $Helper;

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldThrowErrorIfStringIsNoPathToFile(): void
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessage(
            'File with database connection information not found.'
        );
        $this->Helper = new DatabaseConnectHelper(
            DataTypeString::new('testDatei')
        );
        $this->Helper->connect();
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldReturnDatabaseConnection(): void
    {
        $this->Helper = new DatabaseConnectHelper(DataTypeString::new(
            'config/databaseConfig.inc.php'
        ));
        $this->Helper->connect();
        $this->assertInstanceOf(\mysqli::class, $this->Helper->getConnection());
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testShouldBeInitializedByNewMethod(): void
    {
        $this->Helper = DatabaseConnectHelper::new(DataTypeString::new(
            'config/databaseConfig.inc.php'
        ));
        $this->Helper->connect();
        $this->assertInstanceOf(\mysqli::class, $this->Helper->getConnection());
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\Data\LowLevel\DataTypeString
     * @covers \ruhrpottmetaller\Data\LowLevel\AbstractDataTypeValue
     */
    public function testMethodsShouldBeChainable(): void
    {
        $this->Helper = DatabaseConnectHelper::new(
            DataTypeString::new('config/databaseConfig.inc.php')
        );
        $this->assertInstanceOf(
            \mysqli::class,
            $this->Helper->connect()->getConnection()
        );
    }
}
