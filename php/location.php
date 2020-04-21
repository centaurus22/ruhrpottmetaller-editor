<div id="inhalt" class="inhalt_large">

<?php
require('connect.php');
$query = 'SELECT location.id, location.name AS lname, stadt.name AS sname, location.url,
	location.anzeigen
	FROM location LEFT JOIN stadt ON location.stadt_id = stadt.id
	WHERE stadt.anzeigen = 1 ORDER BY location.name;';
$result = mysqli_query($link, $query) or die ('Daten konnten nicht abgerufen werden.');

if (mysqli_num_rows($result)):

?>
<table id="data">
	<tr>
		<th>Name</th>
		<th>Stadt</th>
		<th>Standard-URL</th>
		<th>Anzeigen</th>
	</tr>
<?php
while ($location = mysqli_fetch_array($result)) {
	if ($location['anzeigen']) {
		$status = 'checked="checked"';
	} 
	else {
		$status = '';
	}
	printf('<tr class="normal_unten">
			<td>
				<input type="text" id="name_%1$u" value="%2$s" 
					onchange="change_value_row(\'location\', \'name\', %1$u)"/>
			</td>
			<td>%4$s</td>
			<td>
				<input type="text" id="url_%1$s" value="%5$s"
					onchange="change_value_row(\'location\', \'url\', %1$u)"/>
			</td>
			<td class="checkbox">
				<input type="checkbox" %3$s name="location_anzeigen"
					onchange="change_binary_row(\'location\', \'anzeigen\', %1$u)"/>
			</td>
		</tr>',
		$location['id'], htmlspecialchars($location['lname'], ENT_QUOTES), $status,
		htmlspecialchars($location['sname'], ENT_QUOTES), htmlspecialchars($location['url'], ENT_QUOTES));
}
echo '</table>';

else:
	echo "Noch keine Location in der Datenbank.";
endif;

?>
<div>
