
<?php

class ModelVenue {
	//Class to acces and maintain venue data.

	private $mysqli = NULL;

	public function __construct() {
		$mysqli = ConnectModel::db_conncect();
		$this->mysqli = $mysqli;
	}

	public function __destruct() {
		$this->mysqli->close;
	}

	private function getVenues() {
		$query = 'SELECT id, name, stadt_id, url FROM location';
		$result = $this->mysql->query($query);
		return $result;
	}

	private function getVenuesByCity($city_id) {
		$query = sprintf('SELECT id, name, stadt_id, url FROM location WHERE stadt_id=%1$u;', $city_id);
		$result = $this->mysql->query($query);
		return $result;
	}

	private function getVenue($id) {	
		$query = sprintf('SELECT id, name, stadt_id, url FROM location WHERE id=%1$u;', $id);
		$result = $this->mysql->query($query);
		return $result;
	}

	private function setVenue($name, $city_id, $url) {
		$name = $this->mysqli->real_escape_string($name);
		$url = $this->mysqli->real_escape_string($url);
		$query = sprintf('INSERT INTO location SET name="%1$s", stadt_id=%2$u, url="%3$s";',
			$name, $city_id. $url);
		$result = $this->mysql->query($query);
		return $result;
	}

	private function updateVenue($id, $name, $city_id, $url) {
		$name = $this->mysqli->real_escape_string($name);
		$url = $this->mysqli->real_escape_string($url);
		$query = sprintf('UPDATE location SET name="%1$s", stadt_id=%2$u, url="%3$s WHERE id=%4$u";',
		   	$name, $city_id. $url, $id);
		$result = $this->mysql->query($query);
		return $result;
	}
}
