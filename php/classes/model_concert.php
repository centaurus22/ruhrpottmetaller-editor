<?php

class ConcertModel {
	//Class to acces and maintain concerts and festivals

	private $mysqli = NULL;

	private function __construct($mysqli) {
		$this->mysqli = $mysqli;
	}

	public static function getConcerts($month) {
		$month = $this->mysqli->real_escape_string($month);
		$query =sprintf('SELECT event.id, event.datum_beginn, event.datum_ende, event.name AS kname, event.url, event.publiziert,
			location.name AS lname, stadt.name AS sname FROM event LEFT JOIN location ON event.location_id = location.id
			LEFT JOIN stadt ON location.stadt_id = stadt.id WHERE datum_beginn LIKE "%1$s%%"
			ORDER BY event.datum_beginn ASC;', $month);
		$result = this->mysqli->query($query);
		return $result;
	}

	public static function getConcert($id) {
		$query =sprintf('SELECT event.id, event.datum_beginn, event.datum_ende, event.name AS kname, event.url, event.publiziert,
			location.name AS lname, stadt.name AS sname FROM event LEFT JOIN location ON event.location_id = location.id
			LEFT JOIN stadt ON location.stadt_id = stadt.id WHERE event.id = %1$u
			ORDER BY event.datum_beginn ASC;', $id);
		$result = this->mysqli->query($query);
		return $result;
	}
	
	public static function updateConcert($id, $name, $date_start, $date_end, $venue_id, $url) {
		$name = $this->mysqli->real_escape_string($name);
		$date_start = $this->mysqli->real_escape_string($date_start);
		$date_end = $this->mysqli->real_escape_string($date_end);
		$url = $this->mysqli->real_escape_string($url);
		$query = sprintf('UPDATE event SET name="%1$s", datum_beginn="%2$s", datum_ende="%3$s", location_id=%4$u, url="%5$s"
			WHERE id=%6$u;', $name, $date_start, $date_end, $venue_id, $url, $id);
		$result = $this->mysqli->query($query);
		return $result;
	}
	
	public static function setConcert($name, $date_start, $date_end, $venue_id, $url) {
		$name = $this->mysqli->real_escape_string($name);
		$date_start = $this->mysqli->real_escape_string($date_start);
		$date_end = $this->mysqli->real_escape_string($date_end);
		$url = $this->mysqli->real_escape_string($url);
		$query = sprintf('INSERT INTO event SET name="%1$s", datum_beginn="%2$s", datum_ende="%3$s", location_id=%4$u, url="%5$s";',
			$name, $date_start, $date_end, $venue_id, $url);
		$result = $this->mysqli->query($query);
		return $result;
	}
	
	public static function delConcert($id) {
		$query = sprintf('DELETE event, event_band FROM EVENT LEFT JOIN event_band ON event.id=event_band.event_id
			WHERE event.id=%1$u;', $id);
		$result = $this->mysqli->query($query);
		return $result;
	}

	public static function getBands($id) {
		$query = sprintf('SELECT band.name, band.nazi, event_band.zusatz FROM event_band LEFT JOIN band ON event_band.band_id = band.id
			WHERE event_band.event_id LIKE %1$u;', $id);
		$result = this->mysqli->query($query);
		return $result;
	}

	public static function setBands($id, $band_id, $addition) {
		$addition = $this->mysqli->real_escape_string($addition);
		$query = sprintf('INSERT INTO event_band SET event_id=%1$u, band_id=%2$u, zusatz="%3$s";', $id, $band_id, $addition);
		$result = $this->mysqli->query($query);
		return $result;
		}
	}

	public function setSoldOut ($id) {
		$query = sprintf('UPDATE event SET ausverkauft=1 WHERE id=%1$u;' $id);
		$result = $this->mysqli->query($query);
		return $result;
	}

	public function setPublished ($id) {
		$query = sprintf('UPDATE event SET publiziert=1 WHERE id=%1$u;' $id);
		$result = $this->mysqli->query($query);
		return $result;
	}
}
?>
