<?php

namespace ruhrpottmetaller;

use mysqli;
use PHPUnit\Framework\TestCase;

class MysqliConnectTest extends TestCase
{
    protected function setUp(): void
    {
        chdir('deploy/');
    }

    public function testGetMysqli_ReturnProperMysqlObjectIfLoginDataIsCorrect()
    {
        $mysqliConnect = new MysqliConnect();
        $mysqli = $mysqliConnect->getMysqli();
        self::assertInstanceOf(mysqli::class, $mysqli);
    }

    public function testGetMysqli_RequestToMysqliObjectsAndGetTheSameOne()
    {
        $mysqliConnect = new MysqliConnect();
        $mysqli1 = $mysqliConnect->getMysqli();
        $mysqli2 = $mysqliConnect->getMysqli();
        self::assertEquals($mysqli1->thread_id, $mysqli2->thread_id);
    }
}
