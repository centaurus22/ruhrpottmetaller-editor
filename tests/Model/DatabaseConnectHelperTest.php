<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Model;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\DatabaseConnectHelper;

final class DatabaseConnectHelperTest extends TestCase
{
    private DatabaseConnectHelper $Helper;

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     */
    public function testShouldThrowErrorIfStringIsNoPathToFile(): void
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessage(
            'File with database connection information not found.'
        );
        $this->Helper = new DatabaseConnectHelper(
            RmString::new('testDatei')
        );
        $this->Helper->connect();
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldReturnDatabaseConnection(): void
    {
        $this->Helper = new DatabaseConnectHelper(RmString::new(
            'tests/Model/databaseConfig.inc.php'
        ));
        $this->Helper->connect();
        $this->assertInstanceOf(\mysqli::class, $this->Helper->getConnection());
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testShouldBeInitializedByNewMethod(): void
    {
        $this->Helper = DatabaseConnectHelper::new(RmString::new(
            'tests/Model/databaseConfig.inc.php'
        ));
        $this->Helper->connect();
        $this->assertInstanceOf(\mysqli::class, $this->Helper->getConnection());
    }

    /**
     * @covers \ruhrpottmetaller\Model\DatabaseConnectHelper
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject
     */
    public function testMethodsShouldBeChainable(): void
    {
        $this->Helper = DatabaseConnectHelper::new(
            RmString::new('tests/Model/databaseConfig.inc.php')
        );
        $this->assertInstanceOf(
            \mysqli::class,
            $this->Helper->connect()->getConnection()
        );
    }
}
