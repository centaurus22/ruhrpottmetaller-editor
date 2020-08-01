<?php

/**
 * Class to access and manipulate data saved in the session
 * Version 1.0.0
 */
class SessionModel {
	/**
	 * Initializes the session if it is not already initialized.
	 *
	 * @return integer 1 if a session is activated or was already activ, -1 if PHP sessions are disabled.
	 */
	public function __construct() {
		switch(session_status()) {
		case PHP_SESSION_DISABLED:
			return -1;
			break;
		case PHP_SESSION_NONE:
			session_start();
		case PHP_SESSION_ACTIVE:
			return 1;
			break;
		}
	}

	/**
	 * Add an empty array to the PHP Session to save the status of the concert exports on the
	 * default site (opened / closed) if it is not already available.
	 *
	 * @return integer Always 1.
	 */
	private function initConcertDisplayStatus() {
		if(!isset($_SESSION['concert_display_status'])) {
			$_SESSION['concert_display_status'] = array();
		}
		return 1;

	}	

	/**
	 * Add an empty array to the PHP Session to save the lineup in the concert editor if it is not
	 * already available.
	 *
	 * @return integer Always 1.
	 */
	private function initLineUp() {
		if(!isset($_SESSION['lineup'])) {
			$_SESSION['lineup'] = array();
		}
		return 1;
	}

	/**
	 * Check the export status of a concert.
	 *
	 * @param integer id Id of the concert which export status should be checked.
	 * @return integer 1: Export status is open, 0: Export status is closed, -1 id is no integer.
	 */
	public function getConcertDisplayStatusEntry ($id) {
		if (is_int($id)) {
			initConcertDisplayStatus();
			if  (isset($_SESSION['concert_display_status']["$id"]) 
				AND $_SESSION['concert_display_status']["$id"]) {
				return 1;
			} 
			else {
				return 0;

			}
		}
		else {
			return -1;
		}	
	}

	/**
	 * Change the export status of a concert.
	 *
	 * @param integer id Id of the concert.
	 * @return integer 1: The Id is an integer, -1: the id is no ingeger.
	 */
	public function changeConcertDisplayStatusEntry ($id) {
		if (is_int($id)) {
			initConcertDisplayStatus();
			if ($this->getConcertDisplayStatus ($id)) {
				$_SESSION['concert_display_status']["$id"] = 0;
			}
			else {
				$_SESSION['concert_display_status']["$id"] = 1;
			}
			return 1;
		}
		else {
			return -1;
		}
	}

	/**
	 * Delete the array witch contains the export statuses of the concerts.
	 *
	 * @return integer Always 1.
	 */
	public function delConcertDisplayStatusEntry () {
		if (isset($_SESSION['concert_display_status'])) {
			unset($_SESSION['concert_display_status']);
		}
		return 1;
	}

	/**
	 * Add a new band to the lineup array.
	 *
	 * @param integer row Number of the row under which the new band is added.
	 * @return integer 1: parameter is an integer, -1: parameter is no integer.
	 */
	public function setBandLineup($row){
		if (is_int($row)) {
			initLineUp();
			$band = array('first' => 0, 'band_id' => 0, 'addition' => '');
			array_splice($_SESSION['lineup'], $row, 0, $band);
			return 1;
		}
		else {
			return -1;
		}
	}

	/**
	 * Change information in a specific row of the lineup-.
	 *
	 * @param integer row Number of the row.
	 * @param string first First charakter of the band name or '#' for a special charakter
	 * @param integer band_id Band id.
	 * @param string addition Additional information about this special appearance
	 * @return integer 1: row and band_id parameter are integers, -1: one of those parameters are no integer.
	 */
	public function updateBandLineup($row, $first, $band_id, $addition){
		if (is_int($row) AND is_int($band_id)) {
			initLineUp();
			$_SESSION['lineup'][$row] = array('first' => $first,
				'band_id' => $band_id, 'addition' => $addition);
			return 1;
		}
		else {
			return -1;
		}
	}

	/**
	 * Delete a band to the lineup array.
	 *
	 * @param integer row Number of the row which is deleted.
	 * @return integer 1: parameter is an integer, -1: parameter is no integer.
	 */
	public function delBandLineup($row) {
		if (is_int($row)) {
			initLineUp();
			array_splice($_SESSION['lineup'], $row, 1);
			return 1;
		}
		else {
			return -1
		}
	}

	/**
	 * Shift a band up or down in the lineup.
	 *
	 * @param integer row Number of the row which is deleted.
	 * @param string direction Direction in which the band is shifted.
	 * @return integer 1: correct parameters, -1: wrong parameters.
	 */
	public function shiftBandLineup($row, $direction) {
		if (is_int($row) OR ($direction != "up" AND $direction != "down")) {
			initLineUp();
			array_splice($_SESSION['lineup'], $row, 1);
			$lenght_lineup = count($_SESSION['lineup']);
			if ($lenght_lineup > 1) {
				$band_tmp = $_SESSION['lineup'][$row];
				if ($direction == "up" AND $row > 0) {
					$_SESSION['lineup'][$row] = $_SESSION['lineup'][$row - 1];
					$_SESSION['lineup'][$row - 1] = $band_tmp;
				}
				elseif ($direction == "down" AND $row < $lenght_lineup - 1) {
					$_SESSION['lineup'][$row] = $_SESSION['lineup'][$row + 1];
					$_SESSION['lineup'][$row + 1] = $band_tmp;

				}
			}
		}
		else {
			return -1;
		}
	}
}
