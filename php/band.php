<?php

if (isset($_SESSION['band_anfang'])) {
	$anfang = $_SESSION['band_anfang'];
} else {
	$anfang = '';
}

require('connect.php');
switch($anfang) {
	case '':
		$query = 'SELECT id, name, nazi FROM band WHERE id != 1 ORDER BY name';
		break;
	case 's':
		$query = sprintf('SELECT id, name, nazi from band WHERE name NOT REGEXP "^[A-Z,a-z]"
			ORDER BY name;');
		break;
	default:
		$query = sprintf('SELECT id, name, nazi FROM band WHERE id != 1 AND name LIKE "%s%%" 
			ORDER BY name', $anfang);
}
$result = mysqli_query($link, $query) or die ('Daten konnten nicht abgerufen werden.');

if (mysqli_num_rows($result)):

?>
<div id="inhalt" class="inhalt_small">
	<table id="data">
		<tr>
			<th>Name</th>
			<th>Nazi-Bit</th>
		</tr>
<?php
while ($band = mysqli_fetch_array($result)) {
	if($band['nazi'] == 1) {
		$nazi ='checked="checked"';
	} else {
		$nazi = '';
	}
	printf('<tr class="normal_unten">
			<td><input class="name" type="text" id="name_%1$u" name="name_%1$u"
			value="%2$s" onchange="change_value_row(\'band\', \'name\', \'%1$u\')"/></td>
			<td class="checkbox"><input type="checkbox" %3$s 
				onchange="change_binary_row(\'band\', \'nazi\', \'%1$u\')" /></td>
		</tr>', $band['id'], htmlspecialchars($band['name'], ENT_QUOTES), $nazi);
}
echo '</table>';
else:
	echo 'Noch keine Band (mit diesem Anfangsbuchstaben) in der Datenbank';
endif;
?>
</div>
