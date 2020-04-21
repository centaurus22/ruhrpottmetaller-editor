<?php

session_start();
require('connect.php');

if (isset($_SESSION['lineup'])) {
   $lineup = $_SESSION['lineup'];
} else {
   $lineup = array();
   $band = array('position' => '0', 'band_id' => '', 'neue_band' => '', 'zusatz' => '', 'insert' => '1');
   $lineup[] = $band;
   $_SESSION['lineup'] = $lineup;
}

$anzahl = count($lineup);
if (isset($_GET['zeile'])) {
	$zeile = $_GET['zeile'];
	unset($lineup[$zeile]);
	$lineup = array_values($lineup);
	$_SESSION['lineup'] = $lineup;
}

include('lineup.php');

?>
