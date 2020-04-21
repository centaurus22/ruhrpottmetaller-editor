<div id="inhalt" class="inhalt_large">

<?php

if (!isset($_GET['id']) OR $_GET['id'] == '')
{
	echo "Konzert-Id wurde nicht übergeben.";
	exit;
}

$id=(int) $_GET['id'];
$_SESSION['id'] = $id;

$query=sprintf('SELECT name, datum_beginn, datum_ende, location_id, url FROM event
	WHERE id = %u;', $id);
$result=mysqli_query($link, $query);
$event = mysqli_fetch_array($result);

$name = htmlspecialchars($event['name'], ENT_QUOTES);
$datum_beginn = htmlspecialchars($event['datum_beginn'], ENT_QUOTES);
$datum_ende = $event['datum_ende'];
$location_id = (int) $event['location_id'];
$url = htmlspecialchars($event['url'], ENT_QUOTES);

//Stadtliste erstellen
$query = 'SELECT id, name FROM stadt ORDER BY name;';
$staedte = mysqli_query($link, $query) or die ('Städte konnten nicht abgerufen werden');

//Locationsliste erstellen
$query = 'SELECT location.id, location.name AS lname, stadt.name AS sname
		FROM stadt JOIN location
		ON stadt.id = location.stadt_id ORDER BY lname, sname;';
$locations = mysqli_query($link, $query) or die ('Locations konnten nicht abgerufen werden');

//Lineupdaten abrufen

$query = sprintf('SELECT event_band.band_id, event_band.zusatz, band.name FROM event_band JOIN band ON event_band.band_id = band.id WHERE event_id = %u;', $id);
$result = mysqli_query($link, $query);

unset($_SESSION['lineup']);
$lineup = array();

while ($row = mysqli_fetch_array($result)) {
	$band_name = $row['name'];
	if ($band_name == 'Support' OR $band_name == 'TBA') {
		$anfang = '0';
	} else {
		$anfang = substr($band_name, 0, 1);
		if (!preg_match('%[A-Z]%', $anfang)) {
			$anfang = 's';
		}
	}
	$band = array('anfang' => $anfang, 'band_id' => $row['band_id'], 'neue_band' => '', 'zusatz' => $row['zusatz']);
	$lineup[] = $band;
}

$_SESSION['lineup'] = $lineup;

if (is_null($datum_ende)) {
	$days = 1;
} else {
	$datum_beginn_unix = strtotime($datum_beginn);
	$datum_ende_unix = strtotime($datum_ende);
	$seconds = $datum_ende_unix - $datum_beginn_unix;
	$days = $seconds / 86400 + 1;
}

?>

<form action="?site=show&amp;month=<?=$startdate?>&amp;action=edit" method="post"
	id="kreator_formular">
	<div><span class="kreator_label">Konzertname:</span>
		<input type="text" name="name" value="<?=$name?>"/></div>
	<div><span class="kreator_label">Datum:</span>
		<input type="text" name="datum" value="<?=$datum_beginn?>"/> 
		für <input type="text" name="n_tage" size="2" value="<?=$days?>"/> Tag(e)</div>
	<div id="locationwahl1">
		<div><span class="kreator_label">Stadt:</span>
			<select id="stadt_id" name="stadt_id" onchange="get_locations_1()">
				<option value="0"></option>
<?php
while ($row = mysqli_fetch_array($staedte)) {
printf("\t\t\t<option value='%s'>%s</option>\n", $row[0], htmlspecialchars($row[1], ENT_QUOTES));
}
?>
				<option value="n" class="option_fett">Neue Stadt</option>
			</select></div>
		<div id="locationwahl2">
			<div><span class="kreator_label">Location:</span>
				<select name="location_id" id="location_id" 
					onchange="get_locations_2()">
<?php
while ($row = mysqli_fetch_array($locations)) {
if ($row[0] == $location_id) {
	printf("\t\t\t<option value='%s' selected>%s (%s)</option>\n",
		$row[0], htmlspecialchars($row[1], ENT_QUOTES), htmlspecialchars($row[2], ENT_QUOTES));
} else {	
	printf("\t\t\t<option value='%s' >%s (%s)</option>\n",
		$row[0], htmlspecialchars($row[1], ENT_QUOTES), htmlspecialchars($row[2], ENT_QUOTES));
}
}
?>
				</select></div>
		</div>
	</div>
	<div><span class="kreator_label">URL:</span>
		<input type="text" name="url" value="<?=$url?>" /></div>
	<table id="lineup">
<?php include('lineup.php'); ?>
	</table>
	<input type="Submit" value="Speichern" /> 
</form>
</div>
