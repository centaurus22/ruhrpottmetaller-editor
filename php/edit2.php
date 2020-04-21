<?php

if (isset($_POST['datum']) AND $_POST['datum'] == "")
	echo '<div id="fehler">Achtung: Das Datum wurde nicht angegeben!</div>';
elseif (isset($_POST['name']) AND isset($_SESSION['lineup']))
{
	$event_id = (int) $_SESSION['id'];	
	$name = mysqli_real_escape_string($link, $_POST['name']);
	$datum_beginn = mysqli_real_escape_string($link, $_POST['datum']);
	$n_tage = (int) $link, $_POST['n_tage'];
	$stadt_id = mysqli_real_escape_string($link, $_POST['stadt_id']);
	$url = trim(mysqli_real_escape_string($link, $_POST['url']));
	
	//Wenn stadt_id = n, muss der neue städtename abgerufen und eingespeichert werden
	if ($stadt_id == 'n')
	{
		$stadt = mysqli_real_escape_string($link, $_POST['stadt']);
		$query = "INSERT INTO stadt SET name = '$stadt'";
		mysqli_query($link, $query) or die ('Neue Stadt konnte nicht eingespeichert werden');
		//Neue stadt_id abrufen, damit diese dann gespeichert werden kann.
		$query = "SELECT id from stadt WHERE name LIKE '$stadt'";
		$result = mysqli_query($link, $query) or die ('Fehler beim Abrufen der neuen Stadt-Id');
		$location = mysqli_fetch_array($result);
		$stadt_id = $location['id'];
		$location_id = 'n';
	}
	else
	{
		//Wenn neue Stadt gesetzt wird, muss keine location_id abgerufen werden.
		$location_id = mysqli_real_escape_string$link, $_POST['location_id']);
	}

	/*Wenn location_id = n ist oder stadt_id = n, müssen wir den neuen locationnamen abrufen 
	und in die Datanbank einspeichern*/
	if ($location_id == 'n' OR $stadt_id == 'n')
	{
		$location = mysqli_real_escape_string($link, $_POST['location']);
		$query = sprintf('INSERT INTO location set name = "%1$s", stadt_id = %2$u',
			$location, $stadt_id);
		mysqli_query($link, $query) or die ('Neue Location konnte nicht eingespeichert werden');
		//Neue location_id abrufen, damit diese dann gespeichert werden kann.
		$query = "SELECT id FROM location WHERE name LIKE '$location'";
		$result = mysqli_query($link, $query) or die ('Fehler beim Abrufen der neuen LocationId');
		$location = mysqli_fetch_array($result);
		$location_id = $location['id'];
	}
	
	if ($n_tage > 1)
	{
		$datum_beginn_unix = strtotime($datum_beginn);
		$datum_ende_unix = $datum_beginn_unix + ($n_tage - 1) * 86400;
		$datum_ende = date("Y-m-d", $datum_ende_unix);
		$query = "UPDATE event SET name = '$name', datum_beginn = '$datum_beginn',
			 datum_ende = '$datum_ende', location_id = $location_id, url = '$url' 
			WHERE id = $event_id;";
	}
	else
	{
		$query = "UPDATE event SET name = '$name', datum_beginn = '$datum_beginn',
			datum_ende = NULL, location_id = $location_id, url = '$url'
			WHERE id = $event_id;";
	}
	mysqli_query($link, $query);
	$lineup = $_SESSION['lineup'];
	//Altes Lineup löschen.
	$query = sprintf('DELETE FROM event_band WHERE event_id = %u;', $event_id);
	mysqli_query($link, $query) or die ('Alte Lineupdaten konnten nicht gelöscht werden');
	foreach ($lineup as $band) {
		if ($band['band_id'] == 'n' AND $band['neue_band'] != '') {
			//Nicht einspeichern, wenn kein Name gesetzt.
			$neue_band = mysqli_real_escape_string($link, $band['neue_band']);
			$query = sprintf('INSERT INTO band SET name="%s"', $neue_band);
			mysqli_query($link, $query);
			$query = sprintf('SELECT id FROM band WHERE name LIKE "%s"', $band['neue_band']);
			$result = mysqli_query($link, $query)
				or die ('Neue Band konnte nicht abgerufen werden!');
			$datum = mysqli_fetch_array($result);
			$band['band_id'] = $datum['id'];
		}
		if (!($band['band_id'] == 'n' AND $band['neue_band'] == '')) {
			//Nicht speichern, wenn der Name der neuen Band leer ist.
			$query = sprintf('INSERT INTO event_band SET  event_id=%1$u, band_id=%2$u,
				zusatz="%3$s"', $event_id, $band['band_id'], $band['zusatz']);
			mysqli_query($link, $query);
		}
	}
	unset($_SESSION['lineup']);
}

?>
