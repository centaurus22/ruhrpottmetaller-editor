<?php

class connectModel {
	$dbhost = '';
	$dbuser = '';
	$dbuserpass = '';

	public static function db_connect() {
		include(../db_preferences.inc.php);
		$mysqli = new mysqli($dbhost, $dbuser, $dbuserpass, $db);
		if ($mysqli->connect_error) {
			die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
		}
		return $mysqli;
	}
}

?>
