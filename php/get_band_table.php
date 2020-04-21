<tr>
	<th>Name</th>
	<th>Nazi-Bit</th>
</tr>

<?php
session_start();

if (!isset($_GET['anfang'])) {
	exit;
}

require('connect.php');
$anfang = mysqli_real_escape_string($link, $_GET['anfang']);
$_SESSION['band_anfang'] = $anfang;

switch($anfang) {
	case '':
		$query = 'SELECT id, name, nazi FROM band WHERE id != 1 ORDER BY name';
		break;
	case 's':
		$query = sprintf('SELECT id, name, nazi from band 
			WHERE name NOT REGEXP "^[A-Z,a-z]" ORDER BY name;');
		break;
	default:
		$query = sprintf('SELECT id, name, nazi FROM band
			WHERE id != 1 AND name LIKE "%s%%" ORDER BY name', $anfang);
}

$result = mysqli_query($link, $query);
while ($band = mysqli_fetch_array($result)) {
	if ($band['nazi']) {
		$nazi = 'checked="checked"';
	} else {
		$nazi = '';
	}
	printf('<tr class="normal_unten">
			<td><input class="name" type="text" id="name_%1$u" name="name_%1$u"
				value="%2$s"
				onchange="change_value_row(\'band\', \'name\', \'%1$u\')"/></td>
			<td class="checkbox"><input type="checkbox" %3$s 
				onchange="change_binary_row(\'band\', \'nazi\', \'%1$u\')"</td>
		</tr>', $band['id'], htmlspecialchars($band['name'], ENT_QUOTES), $nazi);
				
}

?>
