<?php

class ConcertModel {
	//Class to acces and maintain concerts and festivals

	private $mysqli = NULL;
	private $lineup = NULL;

	public function __construct($mysqli) {
		$this->mysqli = $mysqli;
	}

	public function getConcerts($month) {
		$month = $this->mysqli->real_escape_string($month);
		$query =sprintf('SELECT event.id, event.datum_beginn, event.datum_ende,
			event.name AS kname, event.url, event.publiziert,
			location.name AS lname, stadt.name AS sname FROM event
			LEFT JOIN location ON event.location_id = location.id
			LEFT JOIN stadt ON location.stadt_id = stadt.id WHERE datum_beginn LIKE "%1$s%%"
			ORDER BY event.datum_beginn ASC;', $month);
		$result = $this->mysqli->query($query);
		return $result;
	}

	public function getConcert($id) {
		$query =sprintf('SELECT event.id, event.datum_beginn, event.datum_ende, event.name AS kname,
			event.url, event.publiziert, location.name AS lname,
			stadt.name AS sname FROM event LEFT JOIN location ON event.location_id = location.id
			LEFT JOIN stadt ON location.stadt_id = stadt.id WHERE event.id = %1$u
			ORDER BY event.datum_beginn ASC;', $id);
		$result = $this->mysqli->query($query);
		return $result;
	}
	
	public function updateConcert($id, $name, $date_start, $date_end, $venue_id, $url) {
		$name = $this->mysqli->real_escape_string($name);
		$date_start = $this->mysqli->real_escape_string($date_start);
		$date_end = $this->mysqli->real_escape_string($date_end);
		$url = $this->mysqli->real_escape_string($url);
		$query = sprintf('UPDATE event SET name="%1$s", datum_beginn="%2$s", datum_ende="%3$s",
			location_id=%4$u, url="%5$s"
			WHERE id=%6$u;', $name, $date_start, $date_end, $venue_id, $url, $id);
		$result = $this->mysqli->query($query);
		return $result;
	}
	
	public function setConcert($name, $date_start, $date_end, $venue_id, $url) {
		$name = $this->mysqli->real_escape_string($name);
		$date_start = $this->mysqli->real_escape_string($date_start);
		$date_end = $this->mysqli->real_escape_string($date_end);
		$url = $this->mysqli->real_escape_string($url);
		$query = sprintf('INSERT INTO event SET name="%1$s", datum_beginn="%2$s", datum_ende="%3$s",
			location_id=%4$u, url="%5$s";', $name, $date_start, $date_end, $venue_id, $url);
		$result = $this->mysqli->query($query);
		return $result;
	}
	
	public function delConcert($id) {
		$query = sprintf('DELETE event, event_band FROM EVENT
			LEFT JOIN event_band ON event.id=event_band.event_id
			WHERE event.id=%1$u;', $id);
		$result = $this->mysqli->query($query);
		return $result;
	}

	public function getBands($id) {
		$query = sprintf('SELECT band.name, band.nazi, event_band.zusatz FROM event_band
			LEFT JOIN band ON event_band.band_id = band.id WHERE event_band.event_id LIKE %1$u;', $id);
		$result = $this->mysqli->query($query);
		return $result;
	}

	public function setBand($id, $band_id, $addition) {
		$addition = $this->mysqli->real_escape_string($addition);
		$query = sprintf('INSERT INTO event_band SET event_id=%1$u, band_id=%2$u, zusatz="%3$s";',
			$id, $band_id, $addition);
		$result = $this->mysqli->query($query);
		return $result;
		}

	public function setSoldOut ($id) {
		$query = sprintf('UPDATE event SET ausverkauft=1 WHERE id=%1$u;', $id);
		$result = $this->mysqli->query($query);
		return $result;
	}

	public function setPublished ($id) {
		$query = sprintf('UPDATE event SET publiziert=1 WHERE id=%1$u;', $id);
		$result = $this->mysqli->query($query);
		return $result;
	}

	public function getConcertDisplayStatus ($id) {
		if  (isset($_SESSION['concert_display_status']["$id"]) 
			AND $_SESSION['concert_display_status']["$id"]) {
			return 1;
		} 
		else {
			return 0;

		}
	}

	public function changeConcertDisplayStatus ($id) {
		if ($this->getConcertDisplayStatus ($id)) {
			$_SESSION['concert_display_status']["$id"] = 0;
		}
		else {
			$_SESSION['concert_display_status']["$id"] = 1;
		}

	}

	public static function startConcertDisplaySession() {
		session_start();
		if(!isset($_SESSION['concert_display_status'])) {
			$_SESSION['concert_display_status'] = array();
		}
	}
	
	public function delConcertDisplayStatus () {
		if (isset($_SESSION['concert_display_status'])) {
			unset($_SESSION['concert_display_status']);
		}
	}

	public function setBandLineup($row){
		$band = array('first' => 0, 'band_id' => 0, 'addition' => $addition);
		array_splice($this->item, $row, 0, $band);
	}

	public function updateBandLineup($row, $first, $band_id, $addition){
		$this->lineup[$row] = array('first' => $first, 'band_id' => $band_id, 'addition' => $addition);
	}

	public function delBandLineup($row) {
		array_splice($this->lineup, $row, 1);
	}

	public function shiftBandLineup($row, $direction) {
		$lenght_lineup = count($this->lineup);
		if ($lenght_lineup > 1) {
			$band_tmp = $this->lineup[$row];
			if ($direction == "up" AND $row > 0) {
				$this->lineup[$row] = $this->lineup[$row - 1];
				$this->lineup[$row - 1] = $band_tmp;
			}
			elseif ($direction == "down" AND $row < $lenght_lineup - 1) {
				$this->lineup[$row] = $this->lineup[$row + 1];
				$this->lineup[$row + 1] = $band_tmp;

			}
		}
	}


	public function startBandsSession() {
		session_start();
		if(!isset($_SESSION['lineup'])) {
			$_SESSION['lineup'] = array();
		}
		$this->lineup = $_SESSION['lineup'];
	}

	public function setBandsSession() {
		$_SESSION['lineup'] = $this->lineup;
	}

}
?>
