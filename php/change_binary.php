<?php

//Wenn über so eine Methode in einer Datenbanktabelle Änderungen durchgeführt werden,
//muss auf jeden Fall genau geprüft werden, ob das Feld so auch überschrieben werden darf,
//weil sonst wichtige Daten zerstört werden könnten.

//array mit erlaubten Zugriffsmöglichkeiten
$allowed = array(
	'preferences' => array('at', 'twitter', 'facebook'),
);

//verschiedene tests durchführen, ob der Aufruf legal ist
if (!(isset($_GET['field']) AND isset($_GET['table']))) {
	exit;
}

$field = $_GET['field'];
$table = $_GET['table'];

//Überprüfen, ob Zugriff auf Tabelle und Wert erlaubt ist
if (!(array_key_exists($table, $allowed) AND in_array($field, $allowed[$table]))){
	exit;
}

require('connect.php');
$query = sprintf('SELECT %2$s FROM %1$s;', $table, $field);
$result = mysqli_query($link, $query) or die;
$value = mysqli_fetch_array($result);

//vertauscht 1 mit 0 und umgekehrt
$change_array = array(1, 0);
//Methode mit dem Array kommt mit NULL nicht klar. Daher wird in dem Fall durch 0 ersetzt
if (is_null($value[$field])) {
	$value[$field] = 0;
}
$value_new = $change_array[$value[$field]];
$query = sprintf('UPDATE %1$s SET %2$s=%3$u;', $table, $field, $value_new);
mysqli_query($link, $query) or die;

?>
