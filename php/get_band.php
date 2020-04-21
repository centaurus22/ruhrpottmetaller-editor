<?php

if (isset($_GET['anfang']) AND isset($_GET['zeile'])) {
	require('connect.php');
	$anfang = mysqli_real_escape_string($link, $_GET['anfang']);
	$zeile = (int) $_GET['zeile'];
	session_start();
	if (isset($_SESSION['lineup'])) {
		$lineup = $_SESSION['lineup'];
	} else {
		$lineup = array();
		$band = array('anfang' => '0', 'band_id' => '', 'neue_band' => '', 'zusatz' => '');
		$lineup[] = $band;
		$_SESSION['lineup'] = $lineup;	
	}
	$lineup[$zeile]['anfang'] = $anfang;
	$band_id = $lineup[$zeile]['band_id'];	
	switch($anfang) {
		case '0':
			$lineup[$zeile]['band_id'] = '';
			if ($band_id == '') {
				printf('<option value="" selected></option>
					<option value="n">Neue Band</option>
					<option value="2">Support</option>
					<option value="1">TBA</option>');
			} elseif ($band_id == 'n') {
				printf('<option value=""></option>
					<option value="n" selected>Neue Band</option>
					<option value="2">Support</option>
					<option value="1">TBA</option>');
			} elseif ($band_id == '2') {
				printf('<option value=""></option>
					<option value="n">Neue Band</option>
					<option value="2" selected>Support</option>
					<option value="1">TBA</option>');
			} else {
				printf('<option value=""></option>
					<option value="n">Neue Band</option>
					<option value="2">Support</option>
					<option value="1" selected>TBA</option>');
			}
			break;
		case 's':
			$query = sprintf('SELECT id, name FROM band 
				WHERE name NOT REGEXP "^[A-Z,a-z]" ORDER BY name;', $anfang);
			$bands = mysqli_query($link, $query);
			/*die erste band der nachgeordeneten auswahl muss schon eingespeichert werden,
			 da die ansonsten nicht gespeichert wird, 
			wenn sie gewünscht ist.
			das Speichern wird nicht getriggert, da dies mit onchange() passiert.*/
			$i = 0;
			while ($band = mysqli_fetch_array($bands)) {
				if ($i == 0 AND $lineup[$zeile]['band_id'] != "n") {
					$lineup[$zeile]['band_id'] = $band[0];
					$i = 1;
				}
				
				if ($band[0] == $band_id) {
					printf('<option value="%1$s" %3$s selected>%2$s</option>',
						$band[0], htmlspecialchars($band[1], ENT_QUOTES), $class_term);
				} else {
					printf('<option value="%1$s" %3$s>%2$s</option>',
						$band[0], htmlspecialchars($band[1], ENT_QUOTES), $class_term);
				}
			}
			if ($band_id == 'n') {
				echo "<option value='n' class='option_highlight' selected>Neue Band</option>\n
					</select>";
			} else {
				echo "<option value='n' class='option_highlight'>Neue Band</option>\n
				</select>";
			}
			break;
		default:
			$query = sprintf('SELECT id, name FROM band 
				WHERE name LIKE "%s%%" AND 
				(name NOT LIKE "Support" OR name NOT LIKE "TBA") ORDER BY name', $anfang);
			$bands = mysqli_query($link, $query);
			$i = 0;
			while ($band = mysqli_fetch_array($bands)) {
				if ($i == 0 AND $lineup[$zeile]['band_id'] != "n") {
					$lineup[$zeile]['band_id'] = $band[0];
					$i = 1;
				}
				if ($band[0] == $band_id) {
					printf('<option value="%1$s" selected>%2$s</option>',
						$band[0], htmlspecialchars($band[1], ENT_QUOTES));
				} else {
					printf('<option value="%1$s">%2$s</option>',
						$band[0], htmlspecialchars($band[1], ENT_QUOTES));
				}
			}
			if ($band_id == 'n') {
				echo "<option value='n' class='option_highlight' selected>Neue Band</option>\n
					</select>";
			} else { 
				echo "<option value='n' class='option_highlight'>Neue Band</option>\n
					</select>";
			}
			break;
	}
	$_SESSION['lineup'] = $lineup;
}

?>
