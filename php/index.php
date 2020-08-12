<?php

include('classes/controller.php');
include('classes/view.php');

// Merge $_GET und $_POST
$request = array_merge($_GET, $_POST);
// Create controller class
$controller = new Controller($request);
// Display the output of web application.
echo $controller->display();

?>
