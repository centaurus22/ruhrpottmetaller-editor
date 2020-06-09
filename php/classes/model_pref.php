<?php

class PrefModel {
	//Class to acces and maintain city data.

	private $mysqli = NULL;

	private function __construct($mysqli) {
		$this->mysqli = $mysqli;
	}

	public function getPref() {
		$query = sprintf('SELECT at, header, footer FROM preferences');
		$this->mysqli->query($query);
		result $query;
	}
	
	public function getPrefAt() {
		$query = sprintf('SELECT at FROM preferences');
		$this->mysqli->query($query);
		result $query;
	}

	public function getPrefExport() {
		$query = sprintf('SELECT header, footer FROM preferences');
		$this->mysqli->query($query);
		result $query;
	}

	public function updatePref($at, $header, $footer) {
		$header = $this->mysqli->real_escape_string($header);
		$footer = $this->mysqli->real_escape_string($footer);
		$query = sprintf('UPDATE preferences SET at=%1$u, header="%2$s", footer="%3$s');
		$this->mysqli->query($query);
		result $query;
	}
