<?php

// Include the classes.
include('classes/controller.php');
include('classes/model_connect.php');
include('classes/model_concert.php');
include('classes/model_band.php');
include('classes/model_city.php');
include('classes/model_venue.php');
include('classes/model_pref.php');
include('classes/view.php');

// Merge $_GET und $_POST
$request = array_merge($_GET, $_POST);
// Create controller class
$controller = new Controller($request);
// Display the output of web application.
echo $controller->display();

?>
