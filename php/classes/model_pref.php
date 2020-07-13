<?php

class PrefModel {
	//Class to acces and maintain city data.

	private $mysqli = NULL;


	public function __construct() {
		$mysqli = ConnectModel::db_conncect();
		$this->mysqli = $mysqli;
	}

	public function __destruct() {
		$this->mysqli->close;
	}

	public function getPref() {
		$stmt = $this->mysqli->prepare('SELECT export_lang, header, footer FROM preferences');
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		return $result;
	}
	
	public function getPrefExportLang() {
		$stmt = $this->mysqli->prepare('SELECT export_lang FROM preferences');
		$stmt->execute();
		$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close;
		return $result;
	}

	public function updatePref($export_lang, $header, $footer) {
		$stmt = $this->mysqli->prepare('UPDATE preferences SET export_lang=?, heade=?, footer=?');
		$stmt->bind_param('sss', $export_lang, $header, $footer);
		$stmt->execute();
		$result = $stmt->affected_rows;
		$stmt->close;
		return $result;
	}
}

?>
