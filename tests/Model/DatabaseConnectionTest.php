<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\DatabaseConnection;

final class DatabaseConnectionTest extends TestCase
{
    private DatabaseConnection $Helper;

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldThrowErrorIfStringIsNoPathToFile(): void
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessage(
            'File with database connection information not found.'
        );
        $this->Helper = new DatabaseConnection(
            RmString::new('testDatei')
        );
        $this->Helper->connect();
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnDatabaseConnection(): void
    {
        $this->Helper = new DatabaseConnection(RmString::new(
            'tests/Model/databaseConfig.inc.php'
        ));
        $this->Helper->connect();
        $this->assertInstanceOf(\mysqli::class, $this->Helper->getConnection());
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldBeInitializedByNewMethod(): void
    {
        $this->Helper = DatabaseConnection::new(RmString::new(
            'tests/Model/databaseConfig.inc.php'
        ));
        $this->Helper->connect();
        $this->assertInstanceOf(\mysqli::class, $this->Helper->getConnection());
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseConnection
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testMethodsShouldBeChainable(): void
    {
        $this->Helper = DatabaseConnection::new(
            RmString::new('tests/Model/databaseConfig.inc.php')
        );
        $this->assertInstanceOf(
            \mysqli::class,
            $this->Helper->connect()->getConnection()
        );
    }
}
