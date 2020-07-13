<?php

class BandModel {
	//Class to acces and maintain bands.

	private $mysqli = NULL;

	public function __construct() {
		$mysqli = ConnectModel::db_conncect();
		$this->mysqli = $mysqli;
	}

	public function __destruct() {
		$this->mysqli->close;
	}

	public function getBands($initial) {
		switch($initial) {
		case '':
			$this->mysqli->prepare('SELECT id, name, nazi FROM band ORDER BY name');
			break;
		case 's':
			$this->mysqli->prepare('SELECT id, name, nazi from band WHERE name NOT REGEXP "^[A-Z,a-z]"
				ORDER BY name;');
			break;
		default:
			$this->mysqli->prepare('SELECT id, name, nazi FROM band WHERE name LIKE ? ORDER BY name');
			$stmt->bind_param('i', $initial . '%');

		}
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		return $result;
	}

	public function getBand($id) {
		$stmt = $this->mysqli->prepare('SELECT id, name, nazi FROM band WHERE id=?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		return $result;
	}

	public function setBand($id, $name, $nazi) {
		$stmt = $this->mysqli->prepare('INSERT INTO band SET name=?, nazi=? WHERE id=?');
		$stmt->bind_param('sii', $name, $nazi, $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return ($result);
	}

	public function updateBand() {
		$stmt = $this->mysqli->prepare('UPDATE band SET name=?, nazi=? WHERE id=?');
		$stmt->bind_param('sii', $name, $nazi, $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return ($result);
	}

}
