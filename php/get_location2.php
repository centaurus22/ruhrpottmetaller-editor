<?php

require('connect.php');

if(!isset($_GET['location_id'])){
	exit;
}

$location_id = mysqli_real_escape_string($link, $_GET['location_id']);
$stadt_id = (int) $_GET['stadt_id'];
switch($location_id)
{
	case 'n':
	{
		//Locationliste erstellen
		$query = sprintf('SELECT location.id, location.name AS lname, stadt.name AS sname
				FROM stadt JOIN location
				ON stadt.id = location.stadt_id WHERE stadt.id LIKE "%s"
				ORDER BY lname, sname;', mysqli_real_escape_string($link, $stadt_id));
		$locations = mysqli_query($link, $query);
		echo '<div id="locationwahl2"><span class="kreator_label">Location:</span><select name="location_id" id="location_id" onchange="get_locations_2()">';
		while ($row = mysqli_fetch_array($locations))
			printf("\t\t\t<option value='%s' >%s (%s)</option>\n", $row[0], htmlspecialchars($row[1], ENT_QUOTES), htmlspecialchars($row[2], ENT_QUOTES));
		echo '<option value="n" selected class="option_highlight">Neue Location</option>
			</select></div>
			<div>
				<span class="kreator_label">Neue Location:</span>
				<input type="text" name="location"/>
			</div>
			<div><span class="kreator_label">Standard-URL:</span>
				<input type="text" name="standard_url"/>
			</div>';
		break;
	}
	default:
	{
		//Locationsliste erstellen
		if ($stadt_id == 0)
		{
			$query = 'SELECT location.id, location.name AS lname, stadt.name AS sname
				FROM stadt JOIN location
				ON stadt.id = location.stadt_id
				ORDER BY lname, sname;';
		}
		else
		{
			$query = sprintf('SELECT location.id, location.name AS lname, stadt.name AS sname
				FROM stadt JOIN location
				ON stadt.id = location.stadt_id WHERE stadt.id LIKE "%s"
				ORDER BY lname, sname;', $stadt_id);
		}
		$locations = mysqli_query($link, $query);
		echo '<div><span class="kreator_label">Location:</span><select name="location_id" id="location_id" onchange="get_locations_2()">';
		while ($row = mysqli_fetch_array($locations))
		{
			if ($location_id == $row[0]) {
				printf("\t\t\t<option value='%s' selected=\"selected\">%s (%s)</option>\n",
					$row[0], htmlspecialchars($row[1], ENT_QUOTES), htmlspecialchars($row[2], ENT_QUOTES));
			}
			else {
				printf("\t\t\t<option value='%s' >%s (%s)</option>\n", $row[0], htmlspecialchars($row[1], ENT_QUOTES), htmlspecialchars($row[2], ENT_QUOTES));
			}
		}
		echo '<option value="n" class="option_highlight">Neue Location</option>
			</select></div>';
		break;
	}
}

?>
