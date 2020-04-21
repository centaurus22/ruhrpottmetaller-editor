<?php
session_start();
require('connect.php');

function cmp($a, $b) {
	return ($a['position'] > $b['position']);
}

if (isset($_SESSION['lineup'])) {
   $lineup = $_SESSION['lineup'];
} else {
   $lineup = array();
}

$anzahl = count($lineup);

if (isset($_GET['zeile'])) {
	$zeile = $_GET['zeile'];
	$band = array('anfang' => '0', 'band_id' => '', 'neue_band' => '', 'metal' => '1', 'zusatz' => '');
	if ($zeile == $anzahl) {
		$lineup[] = $band;
	} else {
		array_splice($lineup, $zeile, 0, array($band));
	}
	$_SESSION['lineup'] = $lineup;
}

include('lineup.php');

?>
