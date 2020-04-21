<div id="inhalt" class="inhalt_small">

<?php

//Daten abrufen
$query=sprintf('SELECT event.id, event.datum_beginn, event.datum_ende, event.name AS kname, event.url,
	event.ausverkauft,
	location.name AS lname, stadt.name AS sname FROM event 
	LEFT JOIN location ON event.location_id = location.id
	LEFT JOIN stadt ON location.stadt_id = stadt.id
	WHERE datum_beginn LIKE "%1$s%%"
	ORDER BY event.datum_beginn ASC;', $startdate);
$result=mysqli_query($link, $query) or die ('Daten konnten nicht abgerufen werden');

//Relevante Einstellungen abrufen
$query="SELECT header, footer FROM preferences";
$result_preferences = mysqli_query($link, $query);
$preferences = mysqli_fetch_array($result_preferences);
//header ausgeben
echo nl2br(htmlspecialchars($preferences['header'], ENT_QUOTES)) . "<br /><br />\n";

$wochentage = array('So, ', 'Mo, ', 'Di, ', 'Mi, ', 'Do, ', 'Fr, ', 'Sa, ');

while ($event = mysqli_fetch_array($result)) {
	$datum_beginn = htmlspecialchars($event['datum_beginn'], ENT_QUOTES);
	$datum_ende = $event['datum_ende'];
	if (!is_null($datum_ende)) {
		$datum_ende = htmlspecialchars($datum_ende, ENT_QUOTES);
	}
	$timestamp_beginn = strtotime($datum_beginn);
	$timestamp_ende = strtotime($datum_ende);

	$event_id = (int) $event['id'];
	$name_event = htmlspecialchars($event['kname'], ENT_QUOTES);
	$name_location = htmlspecialchars($event['lname'], ENT_QUOTES);
	$name_stadt = htmlspecialchars($event['sname'], ENT_QUOTES);
	$url = htmlspecialchars($event['url'], ENT_QUOTES);
	$ausverkauft = (int) $event['ausverkauft'];

	$query = sprintf('SELECT band.name, band.nazi, event_band.zusatz FROM event_band 
		LEFT JOIN band ON event_band.band_id = band.id
		WHERE event_band.event_id LIKE %1$u;', $event_id);
	$result2 = mysqli_query($link, $query);
	$bands = mysqli_fetch_all($result2);
	$n_bands = count($bands);

	//Wenn keine Bands angegeben, keine Nachrichten generieren. Unsinnig.
	if ($n_bands == 0) {
		break;
	} else {
		/*Nachricht generieren*/
		if ($name_event != '') {
			if (is_null($datum_ende)) {
				$fb_1 = sprintf('%s%s %s, %s in %s',
					$wochentage[date('w', $timestamp_beginn)],
					date('d.m.',$timestamp_beginn), $name_event, $name_location, 
					$name_stadt);
			} else {
				$fb_1 = sprintf('%s%s bis %s%s: %s, %s in %s',
					$wochentage[date('w', $timestamp_beginn)],
					date('d.m.',$timestamp_beginn),
					$wochentage[date('w', $timestamp_ende)],
					date('d.m.',$timestamp_ende), $name_event, $name_location,
					$name_stadt);
			}
		} else {
			if (is_null($datum_ende)) {
				$fb_1 = sprintf('%s%s %s in %s',
					$wochentage[date('w', $timestamp_beginn)],
					date('d.m.',$timestamp_beginn), $name_location, $name_stadt);
			} else {
				$fb_1 = sprintf('Ab %s%s %s in %s',
					$wochentage[date('w', $timestamp_beginn)],
					date('d.m.',$timestamp_beginn), $name_location, $name_stadt);
			}
		}

		//Wenn Konzert ausverkauft ist, entsprechenden Hinweis anbringen.
		if ($ausverkauft) {
			$fb_1 = sprintf('%s (ausverkauft)', $fb_1);
		}

		if (strpos(mb_strtoupper($name_event,'UTF-8'), mb_strtoupper($bands[0][0], 'UTF-8'))) {
			$first = 1;
		} else {
			$first = 0;
		}
		
		if ($name_event == '') {
				  $fb_2=':<br />';
		} else {
			if ($first == 1) {
				if ($n_bands == 1) {
					$fb_2 = '';
				} else {
					$fb_2='.<br />+ ';
				}
			} else {
				$fb_2='.<br/>Mit ';
			}
		}
		
		$n = $first;
		/*Variable, welche gesetzt wird, wenn bei einer mind. einer Band
			das Nazi-Bit gesetzt ist.*/	
		$nazi = 0;
		//Und nun die  Bandauflistung bauen
		mysqli_data_seek($result2, $first);
		while ($band = mysqli_fetch_array($result2)) {
			//Keine Nachricht ausgeben, wenn bei einer Band das Nazi-Bit gesetzt ist.
			if ($band['nazi'] == 1) {
				$nazi=1;
				break;
			}
			$bands_zusatz = htmlspecialchars($band['zusatz']);
			$band_name = htmlspecialchars($band['name']);
			if ($band_name != 'Support') {
				$band_name = mb_strtoupper($band_name, 'UTF-8');
			}
			if ($bands_zusatz != '') {
				$bands_zusatz = sprintf(' (%s)', $bands_zusatz);
			}
			
			switch ($n) {
			case $first:
				$fb_2=$fb_2.$band_name.$bands_zusatz;
				break;
			case $n_bands - 1:
				$fb_2 = sprintf('%s und %s%s',$fb_2, $band_name, $bands_zusatz);
				break;
			default:
				$fb_2 = sprintf('%s, %s%s',$fb_2, $band_name, $bands_zusatz);
			}
			 $n++;
		}
		if ($nazi == 0){
			/*Facebook-Nachricht zusammen setzen. */
			$fb_3 = sprintf ('.<br/>%s', $url);

			printf("*%s%s%s<br /><br />\n",$fb_1, $fb_2, $fb_3);
		}

	}
} //while
//Ausgabe des Footers
echo nl2br(htmlspecialchars($preferences['footer'], ENT_QUOTES));
?>

</div>
