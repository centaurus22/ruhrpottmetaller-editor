<?php

session_start();

if (!(isset($_GET['pos']) AND isset($_GET['band_id']) AND isset($_GET['edit_id'])))
{
	exit;
}

$pos = (int) $_GET['pos'];
$band_id = (int) $_GET['band_id'];
$edit_id = (int) $_GET['edit_id'];

$_SESSION['bands'][$edit_id][$pos] = $band_id;

require('connect.php');
$query = sprintf('SELECT name FROM band WHERE id = %u', $band_id);
$result = mysqli_query($link, $query);
$band = mysqli_fetch_array($result);
echo htmlspecialchars($band['name'], ENT_QUOTES);

?>
