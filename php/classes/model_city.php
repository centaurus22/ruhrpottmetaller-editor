<?php

/**
 * Class to acces and manipulate the data in the band table.
 * Version 1.0.0
 */
class CityModel {
	//Link identifier for the connection to the database
	private $mysqli = NULL;

	/**
	 * Call the function which initialize the database connection and write the link
	 * identifier into the class variable.
	 */
	public function __construct() {
		$mysqli = ConnectModel::db_conncect();
		$this->mysqli = $mysqli;
	}

	/**
	 * Call the function which initialize the database connection and write the link
	 * identifier into the class variable.
	 */
	public function __destruct() {
		$this->mysqli->close;
	}

	/**
	 * Get city data from the database
	 *
	 * @return array Array with city data.
	 */
	public function getCities() {
		$stmt = $this->mysqli->prepare('SELECT id, name FROM stadt');
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		return $result;
	}

	/**
	 * Get city data from one city which is linked to the submitted id.
	 *
	 * @param integer $id Id of the city.
	 * @return array Array with city data.
	 */
	public function getCity($id) {
		$stmt = $this->mysqli->prepare('SELECT id, name FROM stadt WHERE id=?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		return $result;
	}

	/**
	 * Insert data about a city into the database
	 *
	 * @param string $name Name of the city. 
	 * @return integer Returns 1 for successful operation, -1 for an error.
	 */
	public function setCity($name) {
		$stmt = $this->mysqli->prepare('INSERT INTO stadt SET name=?');
		$stmt->bind_param('s', $name);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}

	/**
	 * Update city data in the database
	 *
	 * @param integer $id Id of the band which is updated.
	 * @param string $name Name of the city. 
	 * @return integer Returns 1 for success, 0 for a non-existent id, -1 for an error.
	 */
	public function updateCity($id, $name) {
		$this->mysqli->prepare('UPDATE stadt SET name=? WHERE id=?');
		$stmt->bind_param('si', $name, $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}	

}
