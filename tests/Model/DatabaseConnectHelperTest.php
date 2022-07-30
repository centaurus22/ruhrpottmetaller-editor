<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use ruhrpottmetaller\Model\DatabaseConnectHelper;
use ruhrpottmetaller\DataType\DataTypeString;
use PHPUnit\Framework\TestCase;

final class DatabaseConnectHelperTest extends TestCase
{
    private DatabaseConnectHelper $Helper;

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
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
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
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
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
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
     * @covers \ruhrpottmetaller\DataType\DataTypeString
     * @covers \ruhrpottmetaller\DataType\AbstractDataTypeValue
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
