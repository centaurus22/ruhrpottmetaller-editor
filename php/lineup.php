<?php

//Array mit allen Buchstaben des Alphabets erzeugen
$alphabet = range('A','Z');

?>

<?php

$i = 0;

if(count($lineup) == 0)
{
	echo '<tr><td><button type="button"  onclick="add_band(1)">
					<img src="grafiken/plus_small.png" alt="hinzufuegen" />
			</button></td></tr>';
}

foreach ($lineup as $lineup_zeile)
{
	//Erstes Drop-Down-Menü
	printf('<tr>
   	<td>
      	Band %1$s:
		</td>
		<td>
			<select class="dropdown" id="anfang_%1$s" onchange="get_band_1(%1$s)">
				<option value="0"></option>', $i);
	foreach ($alphabet as $buchstabe)
	{
		if ($buchstabe == $lineup_zeile['anfang'])
			printf ("<option selected>%s</option>\n", $buchstabe);
		else
			printf ("<option>%s</option>\n", $buchstabe);
	}
	if ($lineup_zeile['anfang'] == 's')
		printf('<option value="s" selected>#</option>');
	else
		printf('<option value="s">#</option>');
	printf('</select></td>
   		<td><select class="dropdown" id="band_id_%1$s" name="band_id_%1$s" onchange="get_band_2(%1$s)">',$i);
	$band_id = htmlspecialchars($lineup_zeile['band_id'], ENT_QUOTES);
	switch($lineup_zeile['anfang'])
	{
		case '0':
			if ($band_id == '')
			{
				printf('<option value="" selected></option>
					<option value="n">Neue Band</option>
					<option value="2">Support</option>
					<option value="1">TBA</option>');
			}
			elseif ($band_id == 'n')
			{
				printf('<option value=""></option>
					<option value="n" selected>Neue Band</option>
					<option value="2">Support</option>
					<option value="1">TBA</option>');
			}
			elseif ($band_id == '2')
			{
				printf('<option value=""></option>
					<option value="n">Neue Band</option>
					<option value="2" selected>Support</option>
					<option value="1">TBA</option>');
			}
			else
			{
				printf('<option value=""></option>
					<option value="n">Neue Band</option>
					<option value="2">Support</option>
					<option value="1" selected>TBA</option>');
			}
			break;
		case 's':
			$query = sprintf('SELECT id, name FROM band WHERE name NOT REGEXP "^[A-Z,a-z]" ORDER BY name;');
			$bands = mysqli_query($link, $query);
			while ($band = mysqli_fetch_array($bands))
			{
				if ($band[0] == $band_id)
					printf('<option value="%1$s" selected>%2$s</option>', $band[0], htmlspecialchars($band[1], ENT_QUOTES));
				else
					printf('<option value="%1$s">%2$s</option>', $band[0], htmlspecialchars($band[1], ENT_QUOTES));
			}
			if ($band_id == 'n')
				echo '<option value="n" class="option_fett" selected>Neue Band</option>';
			else
				echo "<option value='n' class='option_fett'>Neue Band</option>\n";
			break;
		default:
			$query = sprintf('SELECT id, name FROM band 
				WHERE name LIKE "%s%%" AND (name NOT LIKE "Support" OR name NOT LIKE "TBA") ORDER BY name', $lineup_zeile['anfang']);
			$bands = mysqli_query($link, $query);
			while ($band = mysqli_fetch_array($bands))
			{
				if ($band[0] == $band_id)
					printf('<option value="%1$s" selected>%2$s</option>', $band[0], htmlspecialchars($band[1], ENT_QUOTES));
				else
					printf('<option value="%1$s">%2$s</option>', $band[0], htmlspecialchars($band[1], ENT_QUOTES));
			}
			if ($band_id == 'n')
				echo "<option value='n' class='option_fett' selected>Neue Band</option>\n";
			else
				echo "<option value='n' class='option_fett'>Neue Band</option>\n";
			break;
	}
	printf('</select>
		  	<div id="band_%1$s">', $i);
			if ($band_id == 'n') {
				printf('<input class="inputbox" type="text" name="neue_band_%1$s" id="neue_band_%1$s" value="%2$s"
						onchange="save(\'neue_band\',\'%1$s\')"/>',$i, htmlspecialchars($lineup_zeile['neue_band'], ENT_QUOTES));
				}
	printf('</div></td>
			<td>Zusatz: <input class="inputbox" type="text" id="zusatz_%1$s" name="zusatz_%1$s" value="%2$s" onchange="save(\'zusatz\',\'%1$s\')"/></td>
			<td>
				<button type="button"  onclick="del_band(%1$s)"><img src="grafiken/minus_small.png" alt="Löschen" /></button>
				<button type="button"  onclick="add_band(%3$s)"><img src="grafiken/plus_small.png" alt="hinzufuegen" /></button>
				<button type="button"  onclick="shiftup_band(%1$s)"><img src="grafiken/arrow_up_small.png" alt="Hochschieben" /></button>
				<button type="button"  onclick="shiftdown_band(%1$s)"><img src="grafiken/arrow_down_small.png" alt="Runterschieben" /></button>
			</td>
		</tr>',$i, htmlspecialchars($lineup_zeile['zusatz'], ENT_QUOTES), $i + 1);
	//Laufvariable muss hier schon hochgezählt werden
	$i++;
}

?>
