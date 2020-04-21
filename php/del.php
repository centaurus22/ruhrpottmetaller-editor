<?php

if (isset($_GET['id']))
{
	$id = mysqli_real_escape_string($link, $_GET['id']);
	$query = "DELETE event, event_band FROM event
		LEFT JOIN event_band 
		ON event.id = event_band.event_id
		WHERE event.id LIKE '$id'";

	mysqli_query($link, $query) or die ("Fehler beim Löschen");
}

?>
