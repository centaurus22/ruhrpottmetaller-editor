<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Connection;

final class ConnectionTest extends TestCase
{
    private Connection $Helper;

    /**
     * @covers \ruhrpottmetaller\Model\Connection
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
        $this->Helper = new Connection(
            RmString::new('testDatei')
        );
        $this->Helper->connect();
    }

    /**
     * @covers \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldReturnDatabaseConnection(): void
    {
        $this->Helper = new Connection(RmString::new(
            'tests/Model/databaseConfig.inc.php'
        ));
        $this->Helper->connect();
        $this->assertInstanceOf(\mysqli::class, $this->Helper->getConnection());
    }

    /**
     * @covers \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testShouldBeInitializedByNewMethod(): void
    {
        $this->Helper = Connection::new(RmString::new(
            'tests/Model/databaseConfig.inc.php'
        ));
        $this->Helper->connect();
        $this->assertInstanceOf(\mysqli::class, $this->Helper->getConnection());
    }

    /**
     * @covers \ruhrpottmetaller\Model\Connection
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     */
    public function testMethodsShouldBeChainable(): void
    {
        $this->Helper = Connection::new(
            RmString::new('tests/Model/databaseConfig.inc.php')
        );
        $this->assertInstanceOf(
            \mysqli::class,
            $this->Helper->connect()->getConnection()
        );
    }
}
