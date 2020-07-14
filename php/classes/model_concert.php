<?php

//Class to acces and manipulate the data in the event table and the event_band table
class ConcertModel {

	private $mysqli = NULL;

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

}
?>
