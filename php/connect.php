<?php

$username='rpm';
$password='rpm';
$database='rpm';
$host='localhost';

$link = mysqli_connect($host, $username, $password, $database);

$query='SET NAMES "utf8" COLLATE "utf8_general_ci";';
mysqli_query($link, $query);

?>
