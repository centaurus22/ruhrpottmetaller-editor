<?php
session_start();
date_default_timezone_set('Europe/Berlin');

if (!isset($_GET['event_id'])) {
	exit;
}

$event_id = (int) $_GET['event_id'];
$wochentage = array('So, ', 'Mo, ', 'Di, ', 'Mi, ', 'Do, ', 'Fr, ', 'Sa, ');

/*Twitter-Variablen*/
$laenge_ges = 280; //Gesamt zur Verfügung stehende Länge
$laenge_url = 23; //Längenverbauch für einen Link 
$laenge_zwi = 2; //Zeichen zwischen Bandliste und URL.
$laenge_kor = 0; //Korrekturfaktor bei der Nachrichtenlänge

if (isset($_SESSION[sprintf('%u_open',$event_id)]) AND $_SESSION[sprintf('%u_open',$event_id)])
{
	echo ' ';
	$_SESSION[sprintf('%s_open',$event_id)] = 0;
}
else
{
	require('connect.php');
	//Einstellungen abrufen
	$query="SELECT at, twitter, facebook FROM preferences";
	$result=mysqli_query($link, $query);
	if (!mysqli_num_rows($result)) {
		$at = 0;
		$facebook = 1;
		$twitter = 0;
	} 
	else {
		$row = mysqli_fetch_array($result);
		$at = $row['at'];
		$facebook = $row['facebook'];
		$twitter = $row['twitter'];
	}

	$query=sprintf('SELECT event.id, event.datum_beginn, event.datum_ende,
		event.name AS kname, event.url, event.ausverkauft, location.name AS lname, 
		stadt.name AS sname FROM event 
		LEFT JOIN location ON event.location_id = location.id
		LEFT JOIN stadt ON location.stadt_id = stadt.id
		WHERE event.id = "%s"', $event_id);
	$result=mysqli_query($link, $query) 
		or die ('Daten konnten nicht abgerufen werden');
	$event=mysqli_fetch_array($result);
	$datum_beginn = htmlspecialchars($event['datum_beginn'], ENT_QUOTES);
	$datum_ende = $event['datum_ende'];
	if (!is_null($datum_ende)) {
		$datum_ende = htmlspecialchars($datum_ende, ENT_QUOTES);
	}
	$timestamp_beginn = strtotime($datum_beginn);
	$timestamp_ende = strtotime($datum_ende);

	$name_event = htmlspecialchars($event['kname'], ENT_QUOTES);
	$name_location = htmlspecialchars($event['lname'], ENT_QUOTES);
	$name_stadt = htmlspecialchars($event['sname'], ENT_QUOTES);
	$url = htmlspecialchars($event['url'], ENT_QUOTES);
	$ausverkauft = (int) $event['ausverkauft'];

	$query = sprintf('SELECT band.name, event_band.zusatz FROM event_band 
		LEFT JOIN band ON event_band.band_id = band.id
		WHERE event_band.event_id LIKE %1$s', $event_id);
	$result2=mysqli_query($link, $query) or die ('Daten konnten nicht abgerufen werden');
	$bands = mysqli_fetch_all($result2);
	$n_bands = count($bands);

	//Wenn keine Bands angegeben, keine Nachrichten generieren. Unsinnig.  
	if ($n_bands > 0)
	{
		/*Nachricht generieren*/
		if ($name_event != '')
		{
			if (is_null($datum_ende))
			{
				//"$twitter" wird aus den Einstellungen abgerufen
				if ($twitter) {
					$twitter_1 = sprintf('%s%s %s, %s, %s', $wochentage[date('w', $timestamp_beginn)], date('d.m.',$timestamp_beginn), $name_event, $name_location, $name_stadt);
				}
				//"$facebook wird aus den Einstellungen abgerufen
				if ($facebook) {
					$fb_1 = sprintf('%s%s %s, %s in %s', $wochentage[date('w', $timestamp_beginn)], date('d.m.',$timestamp_beginn), $name_event, $name_location, $name_stadt);
				}
			}
			else
			{
				if ($twitter) {
					$twitter_1 = sprintf('Ab %s%s %s, %s, %s', $wochentage[date('w', $timestamp_beginn)], date('d.m.',$timestamp_beginn), $name_event, $name_location, $name_stadt);
				}
				if ($facebook) {
					$fb_1 = sprintf('%s%s bis %s%s: %s, %s in %s', $wochentage[date('w', $timestamp_beginn)], date('d.m.',$timestamp_beginn), $wochentage[date('w', $timestamp_ende)], date('d.m.',$timestamp_ende), $name_event, $name_location, $name_stadt);
				}
			}
		}
		else
		{
			if (is_null($datum_ende))
			{
				if ($twitter) {
					$twitter_1 = sprintf('%s%s %s, %s', $wochentage[date('w', $timestamp_beginn)], date('d.m.',$timestamp_beginn), $name_location, $name_stadt);
				}
				if ($facebook) {
					$fb_1 = sprintf('%s%s %s in %s', $wochentage[date('w', $timestamp_beginn)], date('d.m.',$timestamp_beginn), $name_location, $name_stadt);
				}
			}
			else
			{
				if ($twitter) {
					$twitter_1 = sprintf('Ab %s%s %s, %s', $wochentage[date('w', $timestamp_beginn)], date('d.m.',$timestamp_beginn), $name_location, $name_stadt);
				}
				if ($facebook) {
					$fb_1 = sprintf('Ab %s%s %s in %s', $wochentage[date('w', $timestamp_beginn)], date('d.m.',$timestamp_beginn), $name_location, $name_stadt);
				}
			}
		}

		//Wenn Konzert ausverkauft ist, entsprechenden Hinweis anbringen.
		if ($ausverkauft)
		{
			if ($twitter) {
				$twitter_1 = sprintf('%s (ausverkauft)', $twitter_1);
			}
			if ($facebook) {
				$fb_1 = sprintf('%s (ausverkauft)', $fb_1);
			}
		}
		/*Wenn Bandname im Konzertnamen schon vorkommt, soll er in der Auflistung der Bands 
		ignoriert werden
		 Zählung fängt bei 0 an. */
		if (strpos(mb_strtoupper($name_event,'UTF-8'), mb_strtoupper($bands[0][0], 'UTF-8')) !== false)
			$first = 1;
		else
			$first = 0;
		if ($twitter) {
			$restzeichen = $laenge_ges - $laenge_zwi - $laenge_kor - $laenge_url - mb_strlen($twitter_1, 'UTF-8');


			/*Dafür steht dann ein Plus vor der Auflistung*/
			if ($name_event == '')
				$twitter_2=': ';
			else
			{
				if ($first == 1)
				{
					if ($n_bands == 1)
						$twitter_2 = '';
					else
						$twitter_2='. + ';
				}
				else
					$twitter_2='. Mit ';
			}
			//Variable $twitter_2_1 und $twitter_2_2 muss vorbelegt werden.
			$twitter_2_1 = '';
			$twitter_2_2 = '';

			for ($i = $first; $i <= $n_bands - 1; $i++)
			{

				//1 Spalte: Bandname, 2. Spalte: Zusatz
				//Bandnamen werden groß geschrieben, außer es steht da Support.
				if ($bands[$i][0] != 'Support')
					$bands[$i][0] = mb_strtoupper($bands[$i][0], 'UTF-8');
			
				// Komplette Widergabe vorgenerieren und in dritter Spalte ablegen
				if ($bands[$i][1] == '')
					$bands[$i][] = htmlspecialchars($bands[$i][0], ENT_QUOTES);
				else
					$bands[$i][] = htmlspecialchars(sprintf('%s (%s)', $bands[$i][0], $bands[$i][1]), ENT_QUOTES);
			
				switch ($i)
				{
				case $first:
					$twitter_2_1 = sprintf('%s%s', $twitter_2, $bands[$i][2]);
					if (mb_strlen($twitter_2_1, 'UTF-8')  >= $restzeichen)
						break 2;
					break;
				case $first + 1:
					if ($n_bands == 2)
						$twitter_2_1 = sprintf('%s &amp; %s', $twitter_2, $bands[$i][2]);
					else
						$twitter_2_1 = sprintf('%s, %s', $twitter_2, $bands[$i][2]);
					if (mb_strlen($twitter_2_1, 'UTF-8')  >= $restzeichen)
						break 2;
					break;
				default:
					if ($i+1 != $n_bands)
						$twitter_2_1  = sprintf('%s, %s', $twitter_2, $bands[$i][2]);
					else
						$twitter_2_1  = sprintf('%s &amp; %s', $twitter_2, $bands[$i][2]);
					if (mb_strlen($twitter_2_1, 'UTF-8')  >= $restzeichen)
					{
						$twitter_2_1 = sprintf('%s &amp; mehr', $twitter_2_2);
						if (mb_strlen($twitter_2_1, 'UTF-8')  >= $restzeichen)
						{
							$twitter_2_1 = sprintf('%s &amp; mehr', $twitter_2_3);
							break 2;
						}
						break 2;
					}

				}
				//Shiften
				$twitter_2_3 = $twitter_2_2;
				$twitter_2_2 = $twitter_2_1;
				$twitter_2 = $twitter_2_1;
			}
		
			$twitter_3 = sprintf ('. %s', $url);
			$twitter_2 = $twitter_2_1;

			/*Twitter-Nachricht zusammen setzen. */
			$twitter_ges = $twitter_1.$twitter_2.$twitter_3;
		//Gehört zur IF-Abfrage, ob in den Einstellungen das Generieren der Twitter-Nachricht definiert ist.
		}

		/*Facebook-Nachricht generieren*/
		if ($facebook) {
			if ($name_event == '')
				  $fb_2=':<br />';
			else
			{
				if ($first == 1)
				{
					if ($n_bands == 1)
						$fb_2 = '';
				 	else
						$fb_2='.<br />+ ';
				}
				else
					$fb_2='.<br />Mit ';
			}

			$n = $first;
			//Und nun die  Bandauflistung bauen
			mysqli_data_seek($result2, $first);
			while ($band = mysqli_fetch_array($result2))
			{
				$bands_zusatz = htmlspecialchars($band['zusatz'], ENT_QUOTES);
				$band_name = htmlspecialchars($band['name'], ENT_QUOTES);
				if ($band_name != 'Support') {
					if ($at) {
						$band_name = '@' . mb_strtoupper($band_name, 'UTF-8');
					} else {
						$band_name = mb_strtoupper($band_name, 'UTF-8');
					}
				}
				if ($bands_zusatz != '') $bands_zusatz = sprintf(' (%s)', $bands_zusatz);
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

			//Facebook-Nachricht zusammensetzen.
			$fb_3 = sprintf ('.<br/>%s', $url);

			$fb_ges = sprintf('%s%s%s',$fb_1, $fb_2, $fb_3);
		//Gehört zur Abfrage, ob eine FB-Nachricht generiert werden soll
		}

	//Gehört zur Abfrage, ob überhaupt Bands vorhanden sind.
	}
	else
	{
		$twitter_ges = '';
		$fb_ges = '';
	}	
	echo '<td></td><td colspan="8"><div>';
	if ($twitter && $facebook) {
		printf ('<div class="message_twitter">Twitter: </div><div>%s</div></div>
			<div><div class="message_facebook">Facebook: </div><div>%s</div>', $twitter_ges, $fb_ges);
	}
	elseif ($twitter) {
		printf('<div>%s</div>', $twitter_ges);
	}
	elseif ($facebook) {
		printf('<div>%s</div>', $fb_ges);
	}

	$_SESSION[sprintf('%s_open',$event_id)] = 1;
	echo '</div></td>';
}
?>
