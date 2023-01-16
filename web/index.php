<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../vendor/autoload.php';

$input = array_merge($_GET, $_POST);

ruhrpottmetaller\Factories\CommandFactory::new()
    ->getCommandController($input)
    ->execute();

echo ruhrpottmetaller\Factories\DisplayFactory::new()
    ->setFactoryBehaviours($input)
    ->getDisplayController($input)
    ->render();
