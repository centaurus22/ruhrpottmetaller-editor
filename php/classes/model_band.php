<?php

/**
 * Class to acces and manipulate the data in the band table.
 * Version 1.0.0
 */
class BandModel {
	//Link identifier for the connection to the database
	private $mysqli = NULL;

	/**
	 * Call the function which initialize the database connection and write the link
	 * identifier into the class variable.
	 */
	public function __construct() {
		include_once('model_connect.php');
		$mysqli = ConnectModel::db_connect();
		$this->mysqli = $mysqli;
	}

	/**
	 * Get band data from the database
	 *
	 * @param initial $string Initial letter of the band name in capital letters or an empty string for 
	 * 	all bands or a lowecase s for bands witch names start with a special character.
	 * @return array Array with band data.
	 */
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
		$stmt->close();
		return $result;
	}

	/**
	 * Get band data from one band with the submitted id.
	 *
	 * @param integer $id Id of the band.
	 * @return array Array with band data.
	 */
	public function getBand($id) {
		$stmt = $this->mysqli->prepare('SELECT id, name, nazi FROM band WHERE id=?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close();
		return $result;
	}

	/**
	 * Insert data about a band into the database
	 *
	 * @param string $name Name of the band. 
	 * @param integer $nazi Export status of the band. 0 -> exportable 1-> non-exportable
	 * @return integer Returns 1 for successful operation, -1 for an error.
	 */
	public function setBand($name, $nazi) {
		$stmt = $this->mysqli->prepare('INSERT INTO band SET name=?, nazi=?');
		$stmt->bind_param('sii', $name, $nazi, $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close();
		return ($result);
	}

	/**
	 * Update band data in the database
	 *
	 * @param integer $id Id of the band which is updated.
	 * @param string $name Name of the band. 
	 * @param integer $nazi Export status of the band. 0 -> exportable 1-> non-exportable
	 * @return integer Returns 1 for successful operation, 0 for a non-existent id, -1 for an error.
	 */
	public function updateBand($id, $name, $nazi) {
		$stmt = $this->mysqli->prepare('UPDATE band SET name=?, nazi=? WHERE id=?');
		$stmt->bind_param('sii', $name, $nazi, $id);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close();
		return ($result);
	}

}
