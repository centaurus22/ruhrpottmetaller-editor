<?php
//Aktionen, die sich aus vorhergehenden Seiten ergeben.
if (isset($_GET['action']))
{
	switch ($_GET['action'])
	{
		case 'insert':
			include('insert.php');
			break;
		case 'edit':
			include('edit2.php');
			break;
	}
}
//Aktionen, die sich aus dem Menü ergeben.
if (isset($action))
{
	switch($action)
	{
		case 'del':
			include('del.php');
			break;
		case 'sold_out':
			$table = 'event';
			$field = 'ausverkauft';
			$value_new = 1;
			include('event_change_value_row.php');
		case 'publiziert':
			$table = 'event';
			$field = 'publiziert';
			$value_new = 1;
			include('event_change_value_row.php');
			break;
	}
}

if (isset($_SESSION['lineup']))
	unset($_SESSION['lineup']);

//Einstellungen abrufen
$query="SELECT at, twitter, facebook FROM preferences";
$result=mysqli_query($link, $query);
if (!mysqli_num_rows($result)) {
	$facebook = 1;
	$twitter = 0;
} 
else {
	$row = mysqli_fetch_array($result);
	$facebook = (int) $row['facebook'];
	$twitter = (int) $row['twitter'];
}


$query=sprintf('SELECT event.id, event.datum_beginn, event.datum_ende, event.name AS kname, event.url,
	event.publiziert,
	location.name AS lname, stadt.name AS sname FROM event 
	LEFT JOIN location ON event.location_id = location.id
	LEFT JOIN stadt ON location.stadt_id = stadt.id
	WHERE datum_beginn LIKE "%1$s%%"
	ORDER BY event.datum_beginn ASC', mysqli_real_escape_string($link, $startdate));

$result=mysqli_query($link, $query) or die ('Daten konnten nicht abgerufen werden');

echo '<div id="inhalt" class="inhalt_small">';	

if (!mysqli_num_rows($result)):
	$startdate=htmlspecialchars($startdate, ENT_QUOTES);
?>

<form action='index.php' method='get' id='event_new' class="event_new">
	<input type='hidden' name='date' value='<?=$startdate ?>'> 
	<input type='hidden' name='month' value='<?=$startdate ?>'> 
	<input type='hidden' name='site' value='create'> 
	<button type="submit" form='event_new'>Konzert hinzufügen</button>
</form>
</div>

<?php
	exit;
endif;

$wochentage = array('So, ', 'Mo, ', 'Di, ', 'Mi, ', 'Do, ', 'Fr, ', 'Sa, ');

?>
<table id="data">
<tr>
<th></th>
<th>Datum</th>
<th>Name</th>
<th>Ort</th>
<th>Bands</th>
<th>URL</th>
<th>Admin</th>
</tr>

<?php
while ($event = mysqli_fetch_array($result)) 
{
	$datum_beginn = htmlspecialchars($event['datum_beginn'], ENT_QUOTES);
	$datum_ende = $event['datum_ende'];
	if (!is_null($datum_ende)) {
		$datum_ende = htmlspecialchars($datum_ende, ENT_QUOTES);
	}
	$timestamp_beginn = strtotime($datum_beginn);
	$timestamp_ende = strtotime($datum_ende);

	$event_id = $event['id'];
	$name_event = htmlspecialchars($event['kname'], ENT_QUOTES);
	$name_location = htmlspecialchars($event['lname'], ENT_QUOTES);
	$name_stadt = htmlspecialchars($event['sname'], ENT_QUOTES);
	$url = htmlspecialchars($event['url'], ENT_QUOTES);
	$publiziert = (int) $event['publiziert'];

	$query = sprintf('SELECT band.name, band.nazi, event_band.zusatz FROM event_band 
		LEFT JOIN band ON event_band.band_id = band.id
		WHERE event_band.event_id LIKE %1$s', $event_id);
	$result2 = mysqli_query($link, $query);
	if ((($timestamp_beginn - time() < 1209600 AND is_null($datum_ende)) 
		OR ($timestamp_beginn - time() < 5184000 AND !is_null($datum_ende))) AND $publiziert == 0) {
		$status='urgent';
	}
	elseif ($publiziert) {
		$status='published';
	}
	else { 
		$status='unpublished';
	}
	?>

	<tr <?php printf('class="%s_oben"', $status) ?>>
	<td>
<?php
	if ($twitter || $facebook) {
		printf('<img src="grafiken/plus_small.png" alt="oeffnen" class="image_message_gen" onclick="show_message(%s)"/>', $event_id);
	}
?>
	</td>
	<td>
		
<?php
if ( is_null($datum_ende)) {
	echo sprintf('%s%s', $wochentage[date('w', $timestamp_beginn)], date('d.m.Y', $timestamp_beginn));
} else {
	echo sprintf('%s%s bis %s%s', $wochentage[date('w', $timestamp_beginn)], date('d.m.Y', $timestamp_beginn), 
		$wochentage[date('w', $timestamp_ende)], date('d.m.Y', $timestamp_ende));
}
?>
	</td>
	<td class="show_name"><?=$name_event?></td>
	<td><?php printf('%s, %s',$name_location, $name_stadt);?></td>
	<td>
<?php 
$n_bands = mysqli_affected_rows($link);
$n = 0;
while ($band = mysqli_fetch_array($result2)) 
{
	$zusatz_band = htmlspecialchars($band['zusatz'], ENT_QUOTES);
	$band_name = htmlspecialchars($band['name'], ENT_QUOTES);
	//"Support" soll nicht in Großbuchstaben geschrieben werden.
	if ($band_name != 'Support')
		$band_name = mb_strtoupper($band_name, 'UTF-8');
	//Bands mit Nazi-Bit werden braun geschrieben
	if($band['nazi']) {
		echo '<span class="nazi">';
	}
	if ($zusatz_band == '') {
		if ($n  == $n_bands - 1) {
			printf('%s', $band_name);
		} 
		else {
			printf('%s, ', $band_name);
		}
	}
	else {
		if ($n  == $n_bands - 1) {
			printf('%s (%s)', $band_name, $zusatz_band);
		}
		else { 
			printf('%s (%s), ', $band_name, $zusatz_band);
		}
	}
	if($band['nazi'] == 1)
	{
		echo '</span>';
	}
	$n++;
} 
?>
	</td>
	<td class="show_url">
		<?php printf('<a class="%2$s"  href="%1$s">%1$s</a>', $url, $status);?>
	<td class="table_buttons">
		<form action='index.php' method='get' id='<?=$event_id ?>'>
			<select name="site" size="1" label="Aktion wählen">
				<option value="create">add</option>
				<option value="edit">edit</option>
				<option value="publiziert">publiziert</option>
				<option value="del">del</option>
				<option value="sold_out">sold out</option>
			</select>
			<input type='hidden' name='date' value='<?=$datum_beginn ?>'> 
			<input type='hidden' name='month' value='<?=$startdate ?>'> 
			<input type='hidden' name='id' value='<?=$event_id?>'> 
			<button type="submit" form='<?=$event_id?>'>Ok</button>
		</form>
	</td>
	</tr>
	<tr <?php printf('class="%s_unten" id=event_%s', $status, $event_id) ?>>
	</tr>

	<?php
}
?>

</table>
</div>
