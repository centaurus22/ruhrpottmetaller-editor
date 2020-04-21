<?php

session_start();
require("connect.php");

if (isset($_SESSION['lineup'])) {
	$lineup = $_SESSION['lineup'];
}
else {
   $lineup = array();
   $band = array('anfang' => '0', 'band_id' => '', 'neue_band' => '', 'zusatz' => '');
   $lineup[] = $band;
   $_SESSION['lineup'] = $lineup;
}

$anzahl = count($lineup);

if ($anzahl > 0 AND isset($_GET['zeile']) AND isset($_GET['direction'])) {
	$zeile = $_GET['zeile'];
	$direction = $_GET['direction'];
	
	if ($direction == "up" AND $zeile > 0)
	{
		$row_tmp = $lineup[$zeile];
		$lineup[$zeile] = $lineup[$zeile - 1];
		$lineup[$zeile - 1] = $row_tmp;
	}

	if ($direction == "down" AND $zeile < $anzahl - 1 )
	{
		$row_tmp = $lineup[$zeile];
		$lineup[$zeile] = $lineup[$zeile + 1];
		$lineup[$zeile + 1] = $row_tmp;
	}
	
	$lineup = array_values($lineup);
	$_SESSION['lineup'] = $lineup;
}

include("lineup.php");

?>
