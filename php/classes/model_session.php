<?php

//Class to access and manipulate data saved in the session
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

	private function initConcertDisplayStatus {
		if(!isset($_SESSION['concert_display_status'])) {
			$_SESSION['concert_display_status'] = array();
		}

	}	

	private function initLineUp {
		if(!isset($_SESSION['lineup'])) {
			$_SESSION['lineup'] = array();
		}
	}

	public function getConcertDisplayStatusEntry ($id) {
		initConcertDisplayStatus();
		if  (isset($_SESSION['concert_display_status']["$id"]) 
			AND $_SESSION['concert_display_status']["$id"]) {
			return 1;
		} 
		else {
			return 0;

		}
	}

	public function changeConcertDisplayStatusEntry ($id) {
		initConcertDisplayStatus();
		if ($this->getConcertDisplayStatus ($id)) {
			$_SESSION['concert_display_status']["$id"] = 0;
		}
		else {
			$_SESSION['concert_display_status']["$id"] = 1;
		}
		return 1;
	}

	public function delConcertDisplayStatusEntry () {
		initConcertDisplayStatus();
		if (isset($_SESSION['concert_display_status'])) {
			unset($_SESSION['concert_display_status']);
		}
		return 1;
	}

	public function setBandLineup($row){
		initLineUp();
		$band = array('first' => 0, 'band_id' => 0, 'addition' => $addition);
		array_splice($_SESSION['lineup'], $row, 0, $band);
	}

	public function updateBandLineup($row, $first, $band_id, $addition){
		initLineUp();
		$_SESSION['lineup'][$row] = array('first' => $first,
			'band_id' => $band_id, 'addition' => $addition);
	}

	public function delBandLineup($row) {
		initLineUp();
		array_splice($_SESSION['lineup'], $row, 1);
	}

	public function shiftBandLineup($row, $direction) {
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


}

class SessionModel {
	public static function startConcertDisplaySession() {
		switch(session_status()) {
		case PHP_SESSION_DISABLED:
			return -1;
			break;
		case PHP_SESSION_NONE:
			session_start();
		case PHP_SESSION_ACTIVE:
			if(!isset($_SESSION['concert_display_status'])) {
				$_SESSION['concert_display_status'] = array();
			}
			return 1;
		}
	}
	
	public function getConcertDisplayStatus ($id) {
		if (!$this->startConcertDisplaySession()) {
			return -1;
		}
		if  (isset($_SESSION['concert_display_status']["$id"]) 
			AND $_SESSION['concert_display_status']["$id"]) {
			return 1;
		} 
		else {
			return 0;

		}
	}

	public function changeConcertDisplayStatus ($id) {
		if (!$this->startConcertDisplaySession()) {
			return -1;
		}
		if ($this->getConcertDisplayStatus ($id)) {
			$_SESSION['concert_display_status']["$id"] = 0;
		}
		else {
			$_SESSION['concert_display_status']["$id"] = 1;
		}
		return 1;
	}

	public function delConcertDisplayStatus () {
		if (!$this->startConcertDisplaySession()) {
			return -1;
		}
		if (isset($_SESSION['concert_display_status'])) {
			unset($_SESSION['concert_display_status']);
		}
		return 1;
	}

	public function startBandsSession() {
		switch(session_status()) {
		case PHP_SESSION_DISABLED:
			return -1;
			break;
		case PHP_SESSION_NONE:
			session_start();
		case PHP_SESSION_ACTIVE:
			if(!isset($_SESSION['lineup'])) {
				$_SESSION['lineup'] = array();
			}
			$this->lineup = $_SESSION['lineup'];
			return 1;
		}
	}

	public function setBandLineup($row){
		if (!$this->startBandsSession()) {
			return -1;
		}
		$band = array('first' => 0, 'band_id' => 0, 'addition' => $addition);
		array_splice($this->item, $row, 0, $band);
	}

	public function updateBandLineup($row, $first, $band_id, $addition){
		if (!$this->startBandsSession()) {
			return -1;
		}
		$this->lineup[$row] = array('first' => $first, 'band_id' => $band_id, 'addition' => $addition);
	}

	public function delBandLineup($row) {
		if (!$this->startBandsSession()) {
			return -1;
		}
		array_splice($this->lineup, $row, 1);
	}

	public function shiftBandLineup($row, $direction) {
		if (!$this->startBandsSession()) {
			return -1;
		}
		$lenght_lineup = count($this->lineup);
		if ($lenght_lineup > 1) {
			$band_tmp = $this->lineup[$row];
			if ($direction == "up" AND $row > 0) {
				$this->lineup[$row] = $this->lineup[$row - 1];
				$this->lineup[$row - 1] = $band_tmp;
			}
			elseif ($direction == "down" AND $row < $lenght_lineup - 1) {
				$this->lineup[$row] = $this->lineup[$row + 1];
				$this->lineup[$row + 1] = $band_tmp;

			}
		}
	}
}
