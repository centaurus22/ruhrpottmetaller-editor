
<?php

session_start();

if (!(isset($_GET['pos']) AND isset($_GET['edit_id'])))
{
	exit;
}

$edit_id = (int) $_GET['edit_id'];

switch ($_GET['pos']) {
	case 'ename':
		$pos = 'name';
		break;
	case 'lname':
		$pos = 'location_id';
		break;
	case 'url':
		$pos = 'url';
		break;
	case 'datum_beginn':
		$pos = 'datum_beginn';
		break;
	case 'days':
		$pos = 'datum_ende';
		break;
	default:
		exit;
}

require('connect.php');
$query = sprintf('SELECT %1$s FROM event_edit WHERE id = %2$u', $pos, $edit_id);
$result = mysqli_query($link, $query);
$datum = mysqli_fetch_array($result);
$new = $datum[$pos];

$_SESSION['daten'][$edit_id][$pos] = $new;

if ($pos == 'location_id')
{
	$query = sprintf('SELECT stadt.name AS sname, location.name AS lname FROM location
		JOIN stadt ON location.stadt_id = stadt.id WHERE location.id = %u', $new);
	$result = mysqli_query($link, $query);
	$location = mysqli_fetch_array($result);
	$new = sprintf('%s, %s', $location['lname'], $location['sname']);
}

echo $new;

?>
