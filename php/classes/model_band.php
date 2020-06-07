<?php

class BandModel {
	//Class to acces and maintain concerts and festivals

	private $mysqli = NULL;

	private function __construct($mysqli) {
		$this->mysqli = $mysqli;
	}

	public static function getBands($initial) {
		$initial = $this->mysqli->real_escape_string($initial);
		switch($initial) {
		case '':
			$query = 'SELECT id, name, nazi FROM band ORDER BY name';
			break;
		case 's':
			$query = sprintf('SELECT id, name, nazi from band WHERE name NOT REGEXP "^[A-Z,a-z]"
				ORDER BY name;');
			break;
		default:
			$query = sprintf('SELECT id, name, nazi FROM band WHERE name LIKE "%s%%"
				ORDER BY name', $initial);
		}
		$result = $this->mysqli->query($query);
		return ($result);
	}

	public static function getBand($id) {
		$query = sprintf('SELECT id, name, nazi FROM band WHERE id=%1$u', $id)
		$result = $this->mysqli->query($query);
		return ($result);
	}

	public static function setBand($id, $name, $nazi) {
		$name = $this->mysqli->real_escape_string($name);
		$query = sprintf('INSERT INTO band SET name="%1$s", nazi="%2$u" WHERE id=%3$u;', $name, $nazi)
		$result = $this->mysqli->query($query);
		return ($result);
	}

	public static function updateBand() {
		$name = $this->mysqli->real_escape_string($name);
		$query = sprintf('UPDATE band SET name="%1$s", nazi="%2$u" WHERE id=%3$u;', $name, $nazi)
		$result = $this->mysqli->query($query);
		return ($result);

	}

}
