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
		$query = 'SELECT id, name FROM stadt;';
		$result = $this->mysqli->query($query);
		return $result;
	}

	public function getCity($id) {
		$query = sprintf('SELECT id, name FROM stadt WHERE id=%1$u;', $id);
		$result = $this->mysqli->query($query);
		return $result;
	}

	public function setCity($name) {
		$name = $this->mysqli->real_escape_string($name);
		$query = sprintf('INSERT INTO stadt SET name="%1$s;', $name);
		$result = $this->mysqli->query($query);
		return $result;
	}

	public function updateCity($id, $name) {
		$name = $this->mysqli->real_escape_string($name);
		$query = sprintf('UPDATE stadt SET name="%1$s" WHERE id=%2$u;', $name, $id);
		$result = $this->mysqli->query($query);
		return $result;
	}	

}
