<?php
session_start();


if (isset($_SESSION['lineup']))
	$lineup = $_SESSION['lineup'];
else
{
	$lineup = array();
	$band = array('anfang' => '0', 'band_id' => '', 'neue_band' => '', 'zusatz' => '');
	$lineup[] = $band;
	$_SESSION['lineup'] = $lineup;	
}

if (!isset($_GET['zeile']) OR !isset($_GET['wert']) OR !isset($_GET['feld'])) {
	exit;
}

$zeile = (int) $_GET['zeile'];
$wert = $_GET['wert'];
$feld = $_GET['feld'];



if ($zeile < 10000 AND $zeile >= 0)
{
	switch($feld)
	{
		case 'zusatz':
			$lineup[$zeile]['zusatz'] = $wert;
			break;
		case 'band_id':
			$lineup[$zeile]['band_id'] = $wert;
			break;
		case 'neue_band':
			$lineup[$zeile]['neue_band'] = $wert;
			break;
	}
	$_SESSION['lineup'] = $lineup;
}


?>
