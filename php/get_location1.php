<?php

require('connect.php');

if(!isset($_GET['stadt_id'])) {
	exit;
}

$stadt_id = mysqli_real_escape_string($link, $_GET['stadt_id']);
switch($stadt_id)
{
	case '0':
	{
		//Stadtliste erstellen
		$query = 'SELECT id, name FROM stadt ORDER BY name;';
		$staedte = mysqli_query($link, $query) or die ('Städte konnten nicht abgerufen werden');
			
		//Locationsliste erstellen
		$query = 'SELECT location.id, location.name AS lname, stadt.name AS sname
				FROM stadt JOIN location
				ON stadt.id = location.stadt_id ORDER BY lname, sname;';
		$locations = mysqli_query($link, $query) or die ('Locations konnten nicht abgerufen werden');

?>
			<div>
				<span class="kreator_label">Stadt:</span>
				<select id="stadt_id" name="stadt_id" onchange="get_locations_1()">
					<option value="0"></option>
<?php
	
while ($row = mysqli_fetch_array($staedte)){
	printf('<option value="%s">%s</option>', $row[0], htmlspecialchars($row[1], ENT_QUOTES));
}

?>
					<option value="n" class="option_highlight">Neue Stadt</option>
				</select>
			</div>
			<div id="locationwahl2">
				<div>
					<span class="kreator_label">Location:</span>
					<select name="location_id" id="location_id" onchange="get_locations_2()">
<?php

while ($row = mysqli_fetch_array($locations)) {
	printf("\t\t\t<option value='%s' >%s (%s)</option>\n", $row[0], htmlspecialchars($row[1], ENT_QUOTES), htmlspecialchars($row[2], ENT_QUOTES));
}

?>
					</select>
				</div>
			</div>
<?php

break;
}
	case 'n':
	{
		/*	
			Stadtliste erstellen
		  	Städteliste wird trotzdem zur Auswahl angeboten, damit der User immer noch dort auswählen kann,
			falls er sich verwählt hat
		*/
		$query = 'SELECT id, name FROM stadt ORDER BY name;';
	
		$staedte = mysqli_query($link, $query) or die ('Städte konnten nicht abgerufen werden');
?>
			<div>
				<span class="kreator_label">Stadt:</span>
				<select id="stadt_id" name="stadt_id" onchange="get_locations_1()">
					<option value="0"></option>
<?php

while ($row = mysqli_fetch_array($staedte)) {
	if ($row[0] == $stadt_id) {
		printf("\t\t\t<option value='%s' selected>%s</option>\n", $row[0], htmlspecialchars($row[1], ENT_QUOTES));
	}
	else {
	printf("\t\t\t<option value='%s'>%s</option>\n", $row[0], htmlspecialchars($row[1], ENT_QUOTES));
	}
}
?>
					<option value="n" selected="selected" class="option_highlight"> Neue Stadt</option>
				</select>
			</div>
			<div>
				<span class="kreator_label">Neue Stadt:</span>
				<input type="text" name="stadt" />
			</div>
			<div>
				<span class="kreator_label">Neue Location:</span>
				<input type="text" name="location" /></div>
			<div>
				<span class="kreator_label">Standard-URL:</span>
				<input type="text" name="standard_url" />
			</div>
<?php

		break;
	}
	default: {
		//Stadtliste erstellen
		$query = 'SELECT id, name FROM stadt ORDER BY name;';
		$staedte = mysqli_query($link, $query) or die ('Städte konnten nicht abgerufen werden');

		//Locationsliste erstellen
		$query = sprintf('SELECT location.id, location.name AS lname, stadt.name AS sname
			FROM stadt JOIN location
			ON stadt.id = location.stadt_id WHERE stadt.id LIKE "%s"
			ORDER BY lname, sname;', $stadt_id);
		$locations = mysqli_query($link, $query);

		echo '<div>
				<span class="kreator_label">Stadt:</span>
				<select id="stadt_id" name="stadt_id" onchange="get_locations_1()">
					<option value="0"></option>';
		while ($row = mysqli_fetch_array($staedte)) {
				if ($row[0] == $stadt_id) {
					printf("\t\t\t<option value='%s' selected=\"selected\">%s</option>\n", $row[0], htmlspecialchars($row[1], ENT_QUOTES));
				}
				else {
					printf("\t\t\t<option value='%s'>%s</option>\n", $row[0], htmlspecialchars($row[1], ENT_QUOTES));
				}
		}
?>
						<option value="n" class="option_highlight">Neue Stadt</option>
					</select>
				</div>
				<div id="locationwahl2">
					<div>
						<span class="kreator_label">Location:</span>
						<select name="location_id" id="location_id" onchange="get_locations_2()">';
<?php
		
while ($row = mysqli_fetch_array($locations)) {
	printf("\t\t\t<option value='%s' >%s (%s)</option>\n", $row[0], htmlspecialchars($row[1], ENT_QUOTES), htmlspecialchars($row[2], ENT_QUOTES));
}

?>
							<option value="n" class="option_highlight">Neue Location</option>
						</select>
					</div>
				</div>
<?php
			break;
	}
}

?>
