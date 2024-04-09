<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Model\Connection;
use ruhrpottmetaller\Factories\{CommandFactory, DisplayFactory};

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../vendor/autoload.php';

$input = array_merge($_GET, $_POST);

$pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
$databaseConnection = Connection::new($pathToDatabaseConfig)
    ->connect()
    ->getConnection();

CommandFactory::new($databaseConnection)
    ->getCommandController($input)
    ->execute();

echo DisplayFactory::new($databaseConnection)
    ->setFactoryBehaviours($input)
    ->getDisplayController($input)
    ->render();
