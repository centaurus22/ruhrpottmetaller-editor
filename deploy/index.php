<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'vendor/autoload.php';

$request = array_merge($_GET, $_POST);
$Controller = new ruhrpottmetaller\Controller($request);
echo $Controller->getOutput();
