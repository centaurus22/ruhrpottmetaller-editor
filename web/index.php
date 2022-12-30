<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../vendor/autoload.php';

$input = array_merge($_GET, $_POST);
$Controller = ruhrpottmetaller\Factories\DisplayFactory::new()
    ->setFactoryBehaviours($input)
    ->getDisplayController($input);
echo $Controller->render();
