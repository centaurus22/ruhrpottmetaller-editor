<?php
//Stadtliste erstellen
$query = 'SELECT id, name FROM stadt ORDER BY name;';
$staedte = mysqli_query($link, $query) or die ('Städte konnten nicht abgerufen werden');

//Locationsliste erstellen
$query = 'SELECT location.id, location.name AS lname, stadt.name AS sname
		FROM stadt JOIN location
		ON stadt.id = location.stadt_id ORDER BY lname, sname;';
$locations = mysqli_query($link, $query) or die ('Locations konnten nicht abgerufen werden');


//Notlöschung
//unset($_SESSION['lineup']);

if (isset($_SESSION['lineup']))
	$lineup = $_SESSION['lineup'];
else
{
	$lineup = array();
	$band = array('anfang' => '0', 'band_id' => '', 'neue_band' => '', 'zusatz' => '');
	$lineup[] = $band;
	$_SESSION['lineup'] = $lineup;	
}

?>
	<div id="inhalt" class="inhalt_large">
		<form action="?site=show&amp;action=insert&amp;month=<?=$startdate?>" method="post" id="kreator_formular">
			<div>
				<span class="kreator_label">Konzertname:</span>
				<input type="text" name="name"  />
			</div>
			<div>
				<span class="kreator_label">Datum:</span>
				<input type="text" name="datum"  value="<?=$date?>"/> 
				für <input type="text" name="n_tage" size="2" value="1"/> Tag(e)
			</div>
			<div id="locationwahl1">
				<div>
					<span class="kreator_label">Stadt:</span>
					<select id="stadt_id" name="stadt_id" onchange="get_locations_1()">
						<option value="0"></option>
<?php

while ($row = mysqli_fetch_array($staedte)){
	printf("\t\t\t\t\t\t<option value='%s'>%s</option>\n", $row[0], htmlspecialchars($row[1], ENT_QUOTES));
}

?>
						<option value="n" class="option_fett">Neue Stadt</option>
					</select>
				</div>
				<div id="locationwahl2">
					<div>
						<span class="kreator_label">Location:</span>
						<select name="location_id"  id="location_id"
							onchange="get_locations_2()">
<?php

while ($row = mysqli_fetch_array($locations)) {
		printf("\t\t\t\t\t\t\t<option value='%s'>%s (%s)</option>\n", $row[0], htmlspecialchars($row[1], ENT_QUOTES),
			htmlspecialchars($row[2], ENT_QUOTES));
}

?>
						</select>
					</div>
				</div>
			</div>
			<div>
				<span class="kreator_label">URL:</span>
				<input type="text" name="url" id="url"  onchange="edit_url()"/>
			</div>
			<table id="lineup">
<?php 

include('lineup.php'); 

?>
			</table>
			<input type="Submit" value="Speichern" /> 
		</form>
	</div>
