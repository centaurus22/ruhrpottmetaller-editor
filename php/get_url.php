<?php

if (!isset($_GET['location_id'])) {
	exit;
}

require('connect.php');
$location_id = (int) $_GET['location_id'];
$query = sprintf('SELECT url FROM location WHERE id = %u', $location_id);
$result = mysqli_query($link, $query);
$location = mysqli_fetch_array($result);
echo htmlspecialchars($location['url'], ENT_QUOTES);
?>
