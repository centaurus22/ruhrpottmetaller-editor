<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../vendor/autoload.php';

// Merge $_GET und $_POST
$request = array_merge($_GET, $_POST);
// Create controller object
$Controller = new ruhrpottmetaller\Controller($request);
// Display the output of web application.
echo $Controller->getOutput();
