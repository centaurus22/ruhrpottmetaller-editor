<?php

namespace ruhrpottmetaller;

use mysqli;
use PHPUnit\Framework\TestCase;

class MysqliConnectTest extends TestCase
{
    public function testGetMysqli_IfNoDataIsOverwrittenInConfigFileRaiseException()
    {
        $this->expectExceptionMessage("Database connection could not be established.");
        $mysqliConnect = new MysqliConnect("../emptyFile.php");
        $mysqliConnect->getMysqli();
    }

    public function testGetMysqli_ReturnProperMysqlObjectIfLoginDataIsCorrect()
    {
        $mysqliConnect = new MysqliConnect("../../deploy/includes/db_preferences.inc.php");
        $mysqli = $mysqliConnect->getMysqli();
        self::assertInstanceOf(mysqli::class, $mysqli);
    }

    public function testGetMysqli_RequestToMysqliObjectsAndGetTheSameOne()
    {
        $mysqliConnect = new MysqliConnect("../../deploy/includes/db_preferences.inc.php");
        $mysqli1 = $mysqliConnect->getMysqli();
        $mysqli2 = $mysqliConnect->getMysqli();
        self::assertEquals($mysqli1->thread_id, $mysqli2->thread_id);
    }
}
