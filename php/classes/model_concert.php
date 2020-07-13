<?php

class ConcertModel {
	//Class to acces and maintain concerts and festivals

	private $mysqli = NULL;
	private $lineup = NULL;

	public function __construct() {
		$mysqli = ConnectModel::db_conncect();
		$this->mysqli = $mysqli;
	}

	public function __destruct() {
		$this->mysqli->close;
	}

	public function getConcerts($month) {
		$stmt = $this->mysqli->prepare('SELECT event.id, event.datum_beginn, event.datum_ende,
			event.name AS kname, event.url, event.publiziert,
			location.name AS lname, stadt.name AS sname FROM event
			LEFT JOIN location ON event.location_id = location.id
			LEFT JOIN stadt ON location.stadt_id = stadt.id WHERE datum_beginn LIKE ?
			ORDER BY event.datum_beginn ASC');
		$stmt->bind_param('s', $month . '%');
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		return $result;
	}

	public function getConcert($id) {
		$stmt = $this->mysqli->prepare('SELECT event.id, event.datum_beginn, event.datum_ende,
			event.name AS kname,
			event.url, event.publiziert, location.name AS lname,
			stadt.name AS sname FROM event LEFT JOIN location ON event.location_id = location.id
			LEFT JOIN stadt ON location.stadt_id = stadt.id WHERE event.id = ?
			ORDER BY event.datum_beginn ASC');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		return $result;
	}
	
	public function updateConcert($id, $name, $date_start, $date_end, $venue_id, $url) {
		$stmt = $this->mysqli->prepare('UPDATE event SET name = ?, datum_beginn = ?, datum_ende = ?,
			location_id = ?, url = ? WHERE id = ?');
		$stmt->bind_param('sssisi', $name, $date_start, $date_end, $venue_id, $url, $id);
		$stmt->execute();
		//Check if the query was successfull
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}
	
	public function setConcert($name, $date_start, $date_end, $venue_id, $url) {
		$stmt = $this->mysqli->prepare('INSERT INTO event SET name = ?, datum_beginn = ?, datum_ende = ?,
			location_id = ?, url = ?');
		$stmt->bind_param('sssis', $name, $date_start, $date_end, $venue_id, $url);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}
	
	public function delConcert($id) {
		$stmt = $this->mysqli->prepare('DELETE event, event_band FROM EVENT
			LEFT JOIN event_band ON event.id=event_band.event_id
			WHERE event.id= ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}

	public function getBands($id) {
		$stmt = $this->mysqli->prepare('SELECT band.name, band.nazi, event_band.zusatz FROM event_band
			LEFT JOIN band ON event_band.band_id = band.id WHERE event_band.event_id LIKE ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		return $result;
	}

	public function setBand($id, $band_id, $addition) {
		$stmt = $this->mysqli->prepare('INSERT INTO event_band SET event_id = ?, band_id = ?, zusatz = ?');
		$stmt->bind_param('iis', $id, $band_id, $addition);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}
	
	public function delBands($id) {
		$stmt = $this->mysqli->prepare('DELETE FROM event_band WHERE event_band.event_id = ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}

	public function setSoldOut ($id) {
		$stmt = $this->mysqli->prepare('UPDATE event SET ausverkauft=1 WHERE id = ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}

	public function setPublished ($id) {
		$stmt = $this->mysqli->prepare('UPDATE event SET publiziert=1 WHERE id= ?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}

	public static function startConcertDisplaySession() {
		switch(session_status()) {
		case PHP_SESSION_DISABLED:
			return -1;
			break;
		case PHP_SESSION_NONE:
			session_start();
		case PHP_SESSION_ACTIVE:
			if(!isset($_SESSION['concert_display_status'])) {
				$_SESSION['concert_display_status'] = array();
			}
			return 1;
		}
	}
	
	public function getConcertDisplayStatus ($id) {
		if (!$this->startConcertDisplaySession()) {
			return -1;
		}
		if  (isset($_SESSION['concert_display_status']["$id"]) 
			AND $_SESSION['concert_display_status']["$id"]) {
			return 1;
		} 
		else {
			return 0;

		}
	}

	public function changeConcertDisplayStatus ($id) {
		if (!$this->startConcertDisplaySession()) {
			return -1;
		}
		if ($this->getConcertDisplayStatus ($id)) {
			$_SESSION['concert_display_status']["$id"] = 0;
		}
		else {
			$_SESSION['concert_display_status']["$id"] = 1;
		}
		return 1;
	}

	public function delConcertDisplayStatus () {
		if (!$this->startConcertDisplaySession()) {
			return -1;
		}
		if (isset($_SESSION['concert_display_status'])) {
			unset($_SESSION['concert_display_status']);
		}
		return 1;
	}

	public function startBandsSession() {
		switch(session_status()) {
		case PHP_SESSION_DISABLED:
			return -1;
			break;
		case PHP_SESSION_NONE:
			session_start();
		case PHP_SESSION_ACTIVE:
			if(!isset($_SESSION['lineup'])) {
				$_SESSION['lineup'] = array();
			}
			$this->lineup = $_SESSION['lineup'];
			return 1;
		}
	}

	public function setBandLineup($row){
		if (!$this->startBandsSession()) {
			return -1;
		}
		$band = array('first' => 0, 'band_id' => 0, 'addition' => $addition);
		array_splice($this->item, $row, 0, $band);
	}

	public function updateBandLineup($row, $first, $band_id, $addition){
		if (!$this->startBandsSession()) {
			return -1;
		}
		$this->lineup[$row] = array('first' => $first, 'band_id' => $band_id, 'addition' => $addition);
	}

	public function delBandLineup($row) {
		if (!$this->startBandsSession()) {
			return -1;
		}
		array_splice($this->lineup, $row, 1);
	}

	public function shiftBandLineup($row, $direction) {
		if (!$this->startBandsSession()) {
			return -1;
		}
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

}
?>
