<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'vendor/autoload.php';

$requestParameters = array_merge($_GET, $_POST);
$Controller = new ruhrpottmetaller\Controller($requestParameters);
echo $Controller->getOutput();
