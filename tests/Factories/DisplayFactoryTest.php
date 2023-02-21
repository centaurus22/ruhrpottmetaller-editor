<?php

declare(strict_types=1);

namespace tests\ruhrpottmetaller\Factories;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Factories\DisplayFactory;
use ruhrpottmetaller\Model\Connection;

class DisplayFactoryTest extends TestCase
{
    protected \mysqli $connection;
    protected function setUp(): void
    {
        $pathToDatabaseConfig = RmString::new('./tests/Model/databaseConfig.inc.php');
        $this->connection = Connection::new($pathToDatabaseConfig)
            ->connect()
            ->getConnection();
    }

    public DisplayFactory $DisplayFactory;

    /**
     * @covers \ruhrpottmetaller\Factories\DisplayFactory
     * @uses  \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Model\Connection
     **/
    public function testShouldCreateDisplayFactory()
    {
        $this->DisplayFactory = new DisplayFactory($this->connection);
        $this->assertInstanceOf(
            DisplayFactory::class,
            $this->DisplayFactory
        );
    }

    /**
     * @covers \ruhrpottmetaller\Factories\AbstractFactory
     * @covers \ruhrpottmetaller\AbstractRmObject
     * @covers \ruhrpottmetaller\Factories\DisplayFactory
     * @uses  \ruhrpottmetaller\Controller\Display\AbstractDisplayController
     * @uses  \ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\AbstractRmString
     * @uses  \ruhrpottmetaller\Data\LowLevel\String\RmString
     * @uses \ruhrpottmetaller\Model\Connection
     **/
    public function testNewShouldCreateDisplayFactory()
    {
        $this->DisplayFactory = DisplayFactory::new($this->connection);
        $this->assertInstanceOf(
            DisplayFactory::class,
            $this->DisplayFactory
        );
    }
}
