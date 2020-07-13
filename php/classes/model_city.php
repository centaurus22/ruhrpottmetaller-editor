<?php

class CityModel {
	//Class to acces and maintain city data.

	private $mysqli = NULL;

	public function __construct() {
		$mysqli = ConnectModel::db_conncect();
		$this->mysqli = $mysqli;
	}

	public function __destruct() {
		$this->mysqli->close;
	}

	public function getCities() {
		$stmt = $this->mysqli->prepare('SELECT id, name FROM stadt');
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		return $result;
	}

	public function getCity($id) {
		$stmt = $this->mysqli->prepare('SELECT id, name FROM stadt WHERE id=?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		return $result;
	}

	public function setCity($name) {
		$stmt = $this->mysqli->prepare('INSERT INTO stadt SET name=?');
		$stmt->bind_param('s', $name);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}

	public function updateCity($id, $name) {
		$this->mysqli->prepare('UPDATE stadt SET name=? WHERE id=?');
		$stmt->bind_param('si', $name, $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}	

}
