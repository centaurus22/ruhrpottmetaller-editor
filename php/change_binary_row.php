<?php

//Wenn über so eine Methode in einer Datenbanktabelle Änderungen durchgeführt werden,
//muss auf jeden Fall genau geprüft werden, ob das Feld so auch überschrieben werden darf,
//weil sonst wichtige Daten zerstört werden könnten.

//array mit erlaubten Zugriffsmöglichkeiten
$allowed = array(
	'band'		=> array('nazi'),
	'blog'		=> array('sticky'),
	'location' 	=> array('anzeigen'),
	'stadt'		=> array('anzeigen'),
);

//verschiedene tests durchführen, ob der Aufruf legal ist
if (!(isset($_GET['field']) AND isset($_GET['table']) AND isset($_GET['id']))) {
	exit;
}

$field 	= $_GET['field'];
$table 	= $_GET['table'];
$id 	= (int) $_GET['id'];

//Überprüfen, ob Zugriff auf Tabelle und Wert erlaubt ist
if (!(array_key_exists($table, $allowed) AND in_array($field, $allowed[$table]))){
	exit;
}

require('connect.php');
$query 	= sprintf('SELECT %2$s FROM %1$s WHERE id=%3$u;', $table, $field, $id);
$result = mysqli_query($link, $query) or die;
$value 	= mysqli_fetch_array($result);

//vertauscht 1 mit 0 und umgekehrt
$change_array = array(1, 0);
//Methode mit dem Array kommt mit NULL nicht klar. Daher wird in dem Fall durch 0 ersetzt
if (is_null($value[$field])) {
	$value[$field] = 0;
}
$value_new = $change_array[$value[$field]];
$query = sprintf('UPDATE %1$s SET %2$s=%4$b WHERE id=%3$u;', $table, $field, $id, $value_new);
mysqli_query($link, $query) or die;

?>
