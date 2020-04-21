<div id="inhalt" class="inhalt_large">

<?php

require('connect.php');
$query = 'SELECT id, name, anzeigen FROM stadt ORDER BY name';
$result = mysqli_query($link, $query) or die ('Daten konnten nicht abgerufen werden.');

if (mysqli_num_rows($result)):

?>

<table id="data">
	<tr>
		<th>Name</th>
		<th>Anzeigen</th>
	</tr>
<?php
	while ($stadt = mysqli_fetch_array($result)) {
		if ($stadt['anzeigen']) {
			$status = 'checked="checked"';
		} else {
			$status = '';
		}
		printf('<tr class="normal_unten">
				<td><input type="text" id="name_%1$u" value="%2$s" 
					onchange="change_value_row(\'stadt\', \'name\', %1$u)"/></td>
				<td class="checkbox"><input type="checkbox" id="stadt_anzeigen" %3$s
					onchange="change_binary_row(\'stadt\', \'anzeigen\', %1$u)"/></td>
			</tr>', $stadt['id'], htmlspecialchars($stadt['name'], ENT_QUOTES), $status);
	}
?>

</table>
</div>

<?php
else:
	echo "Noch keine Stadt in der Datenbank.";
endif;
?>

</div>
