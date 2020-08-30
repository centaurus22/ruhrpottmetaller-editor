<?php

class VenueModel {
	//Class to acces and maintain venue data.

	private $mysqli = NULL;

	public function __construct() {
		include_once('model_connect.php');
		$mysqli = ConnectModel::db_connect();
		$this->mysqli = $mysqli;
	}

	public function getVenues() {
		$stmt = $this->mysqli->prepare('SELECT id, name, stadt_id, url FROM location');
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close();
		return $result;
	}

	public function getVenuesByCity($city_id) {
		$stmt = $this->mysqli->prepare('SELECT id, name, stadt_id, url FROM location
			WHERE stadt_id=?');
		$stmt->bind_param('i', $city_id);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close();
		return $result;
	}

	private function getVenueById($id) {	
		$stmt = $this->mysqli->prepare('SELECT id, name, stadt_id, url FROM location WHERE id=?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close();
		return $result;
	}

	private function setVenue($name, $city_id, $url) {
		$stmt = $this->mysqli->prepare('INSERT INTO location SET name=?, stadt_id=?, url=?');
		$stmt->bind_param('sis', $name, $city_id, $url);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close();
		return $result;
	}

	private function updateVenue($id, $name, $city_id, $url) {
		$stmt = $this->mysqli->prepare('UPDATE location SET name=?, stadt_id=?, url=? WHERE id=?');
		$stmt->bind_param('sisi', $name, $city_id, $url, $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close();
		return $result;
	}
}
