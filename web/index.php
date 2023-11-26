<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Factories\AjaxCommandFactory;
use ruhrpottmetaller\Factories\AjaxDisplayFactory;
use ruhrpottmetaller\Factories\CommandFactory;
use ruhrpottmetaller\Factories\DisplayFactory;
use ruhrpottmetaller\Model\DatabaseConnection;

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../vendor/autoload.php';

$input = array_merge($_GET, $_POST);

$pathToDatabaseConfig = RmString::new('../config/databaseConfig.inc.php');
$databaseConnection = DatabaseConnection::new($pathToDatabaseConfig)
    ->connect()
    ->getConnection();

if (isset($input['ajax']) and isset($input['command'])) {
    $commandFactory = AjaxCommandFactory::new($databaseConnection)
        ->setFactoryBehaviour($input);
} else {
    $commandFactory = CommandFactory::new($databaseConnection);
}

$commandFactory->getCommandController($input)->execute();


if (isset($input['ajax']) and isset($input['content'])) {
    $displayFactory = AjaxDisplayFactory::new($databaseConnection);
} else {
    $displayFactory = DisplayFactory::new($databaseConnection);
}

echo $displayFactory->setFactoryBehaviours($input)
    ->getDisplayController($input)
    ->render();
