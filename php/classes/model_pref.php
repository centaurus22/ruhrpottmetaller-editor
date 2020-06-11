<?php

class PrefModel {
	//Class to acces and maintain city data.

	private $mysqli = NULL;

	private function __construct($mysqli) {
		$this->mysqli = $mysqli;
	}

	public function getPref() {
		$query = sprintf('SELECT at, header, footer FROM preferences');
		$result = $this->mysqli->query($query);
		return $result;
	}
	
	public function getPrefAt() {
		$query = 'SELECT at FROM preferences';
		$result = $this->mysqli->query($query);
		return $result;
	}

	public function getPrefExport() {
		$query = 'SELECT header, footer FROM preferences';
		$result = $this->mysqli->query($query);
		return $result;
	}

	public function updatePref($at, $header, $footer) {
		$header = $this->mysqli->real_escape_string($header);
		$footer = $this->mysqli->real_escape_string($footer);
		$query = sprintf('UPDATE preferences SET at=%1$u, header="%2$s", footer="%3$s');
		$result = $this->mysqli->query($query);
		return $result;
	}
}

?>
