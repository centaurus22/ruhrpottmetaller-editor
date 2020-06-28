<?php

class ConnectModel {
	public static function db_connect() {
		$dbhost = '';
		$dbuser = '';
		$dbuserpass = '';
		$db="";
		include('db_preferences.inc.php');
		$mysqli = new mysqli($dbhost, $dbuser, $dbuserpass, $db);
		if ($mysqli->connect_error) {
			die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
		}
		$query='SET NAMES "utf8" COLLATE "utf8_general_ci";';
		$mysqli->query($query);
		if ($mysqli->error) {
			die('MySQL Error (' . $mysqli->errno . ') ' . $mysqli->error);
		}
		return $mysqli;
	}
}

?>
