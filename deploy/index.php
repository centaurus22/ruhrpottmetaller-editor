<?php

use ruhrpottmetaller\Commands\InterpreterCommandFactory;
use ruhrpottmetaller\Products\ProductFactory;
use ruhrpottmetaller\Storage;

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'vendor/autoload.php';

$request_parameters = array_merge($_GET, $_POST);
$interpreterCommandFactory = new InterpreterCommandFactory(
    commandStorage: new Storage(),
    request_parameters: $request_parameters,
    productFactory: new ProductFactory(product_class_folder: 'ruhrpottmetaller/Products/')
);
$controller = new ruhrpottmetaller\Controller(interpreterCommandFactory: $interpreterCommandFactory);
