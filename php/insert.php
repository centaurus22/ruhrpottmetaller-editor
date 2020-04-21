<?php
	
if (isset($_POST['name']) AND isset($_SESSION['lineup']))
{	
	if ($_POST['datum'] == '')
	{
		echo '<div id="fehler">Achtung: Das Datum wurde nicht angegeben!
			Es wurde das Datum des aktuellen Tages gesetzt.</div>';
		$datum_beginn = date('Y-m-d', time());
		/*Wenn kein Datum gesetzt ist, wird das Datum des aktuellen Tages gesetzt.
		Dadurch erscheint das Konzi auf der Hauptseite und kann einfach editiert werden. */
	}
	elseif($_POST['datum'] != '')
	{
		$datum_beginn = mysqli_real_escape_string($link, $_POST['datum']);
	}

	//Wenn Konzert eingefügt wird, wird der Monat, der angezeigt wird, aus dem Konzertdatum übernommen.
	//Dieser überschreibt ein vorher festgelegtes Datum.
	$datum_beginn_unix = strtotime($datum_beginn);
	$startdate = date("Y-m", $datum_beginn_unix);

	$name = trim(mysqli_real_escape_string($link, $_POST['name']));
	$n_tage = (int) $_POST['n_tage'];
	$stadt_id = mysqli_real_escape_string($link, $_POST['stadt_id']);
	$url = trim(mysqli_real_escape_string($link, $_POST['url']));
	
	//Wenn stadt_id = n, muss der neue städtename abgerufen und eingespeichert werden
	if ($stadt_id == 'n')
	{
		$stadt = mysqli_real_escape_string($link, $_POST['stadt']);
		$query = sprintf('INSERT INTO stadt SET name = "%s"', $stadt);
		mysqli_query($link, $query) or die ('Neue Stadt konnte nicht eingespeichert werden');
		//Neue stadt_id abrufen, damit diese dann gespeichert werden kann.
		$query = sprintf('SELECT id from stadt WHERE name LIKE "%s";', $stadt);
		$result = mysqli_query($link, $query) or die ('Fehler beim Abrufen der neuen LocationId');
		$stadt = mysqli_fetch_array($result);
		$stadt_id = $stadt['id'];
		$location_id = 'n';
	}
	else
	{
		//Wenn neue Stadt gesetzt wird, muss keine location_id abgerufen werden.
		$location_id = mysqli_real_escape_string($link, $_POST['location_id']);
	}

	/*Wenn location_id = n ist oder stadt_id = n, müssen wir den neuen locationnamen abrufen 
	und in die Datanbank einspeichern. Und die Standard-URL der Location, sollte sie vorhanden sein*/
	if ($location_id == 'n' OR $stadt_id == 'n')
	{
		$location = trim(mysqli_real_escape_string($link, $_POST['location']));
		$standard_url = mysqli_real_escape_string($link, $_POST['standard_url']);
		$query = sprintf('INSERT INTO location SET name="%s", stadt_id=%s, url="%s";',
			$location, $stadt_id, $standard_url);
		mysqli_query($link, $query) or die ('Neue Location konnte nicht eingespeichert werden');
		//Neue location_id abrufen, damit diese dann gespeichert werden kann.
		$query = sprintf('SELECT id FROM location WHERE name LIKE "%s";', $location);
		$result = mysqli_query($link, $query) or die ('Fehler beim Abrufen der neuen LocationId');
		$location = mysqli_fetch_array($result);
		$location_id = $location['id'];
	}
	
	if ($n_tage > 1)
	{
		$datum_beginn_unix = strtotime($datum_beginn);
		$datum_ende_unix = $datum_beginn_unix + ($n_tage - 1) * 86400;
		$datum_ende = date('Y-m-d', $datum_ende_unix);
		$query = "INSERT INTO event SET
			name='$name', datum_beginn='$datum_beginn', datum_ende='$datum_ende', 
			location_id=$location_id, url='$url', publiziert=0";
	}
	else
	{
		$query = "INSERT INTO event SET
			name='$name', datum_beginn='$datum_beginn',
			location_id=$location_id, url='$url', publiziert=0";
	}
	mysqli_query($link, $query);
	/* 
	Höchste ID bestimmen, damit die dazugehörigen Bands auch eingespeichert
	werden können.
	*/
	$query = 'SELECT MAX(id) AS id FROM event';
	$result = mysqli_query($link, $query);
	$event = mysqli_fetch_array($result);
	$event_id = $event['id'];
	$lineup = $_SESSION['lineup'];
	foreach ($lineup as $band)
	{
		if ($band['band_id'] == 'n' AND $band['neue_band'] != '')
			
		{
			$neue_band = $band['neue_band'];
			$neue_band = trim($neue_band);
			$neue_band = mysqli_real_escape_string($link, $neue_band);
			$query = sprintf("INSERT INTO band SET name='%s'", $neue_band);
			mysqli_query($link, $query);
			$query = sprintf('SELECT id FROM band WHERE name LIKE "%s"', $neue_band);
			$result = mysqli_query($link, $query);
			$datum = mysqli_fetch_array($result);
			$band['band_id'] = $datum['id'];
		}
		if (!($band['band_id'] == 'n'))
		{
			//Nicht speichern, wenn der Name der neuen Band leer ist.
			$band_id = (int) $band['band_id'];
			$query = sprintf('INSERT INTO event_band SET event_id=%1$s, band_id=%2$s, zusatz="%3$s"', $event_id, $band_id, mysqli_real_escape_string($link, $band['zusatz']));
			mysqli_query($link, $query);
		}
	}
}

?>
