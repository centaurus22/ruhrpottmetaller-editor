<?php

if (isset($_SESSION['lineup']))
	unset($_SESSION['lineup']);

$query='SELECT event.id, event.datum_beginn, event.datum_ende, 
		event.name AS ename, event.url, event.publiziert,
		old_location.name AS old_lname, new_location.name AS new_lname,
			new_stadt.name AS new_sname, old_stadt.name AS old_sname,
		event_edit.id, event_edit.name AS new_ename,
		event_edit.datum_beginn AS new_datum_beginn,
		event_edit.datum_ende AS new_datum_ende,
		event_edit.url AS new_url, event_edit.location_id AS new_location_id,
		event.location_id AS old_location_id
		FROM event 
		JOIN event_edit ON event.id = event_edit.id
		LEFT JOIN location 
			ON event.location_id = old_location.location_id 
		LEFT JOIN location  new_location 
			ON event_edit.location_id = new_location.location_id
		LEFT JOIN stadt new_stadt ON new_location.stadt_id = new_stadt.stadt_id
		LEFT JOIN stadt old_stadt ON old_location.stadt_id = old_stadt.stadt_id
		ORDER BY event.datum_beginn ASC, event_edit.id';
$result=mysqli_query($link, $query)
	or die ('Daten konnten nicht abgerufen werden');


$wochentage = array('So, ', 'Mo, ', 'Di, ', 'Mi, ', 'Do, ', 'Fr, ', 'Sa, ');

$num = mysqli_affected_rows($link);

if ($num == 0) {
	echo 'Es gibt nichts zu tun.';
} else {
	while($todo = mysqli_fetch_array($result)) {
		printf('<div class="aenderungen_todo" id="todo_%s">', $todo['id']);
		include('todo_template.php');
		echo '</div>';
	}
	$_SESSION['daten'] = $daten;
	$_SESSION['bands'] = $bands;
}

?>
