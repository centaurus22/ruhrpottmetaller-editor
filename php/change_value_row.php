<?php


//Wenn über so eine Methode in einer Datenbanktabelle Änderungen durchgeführt werden,
//muss auf jeden Fall genau geprüft werden, ob das Feld so auch überschrieben werden darf,
//weil sonst wichtige Daten zerstört werden könnten.

//array mit erlaubten Zugriffsmöglichkeiten
$allowed = array(
	'band'		=> array('name'),
	'location'	=> array('name', 'url'),
	'stadt'		=> array('name'),
);

//verschiedene tests durchführen, ob der Aufruf legal ist
if (!(isset($_GET['field']) AND isset($_GET['table']) AND isset($_GET['id']) AND isset($_GET['value_new']))) {
	exit;
}

require('connect.php');

$field 		= $_GET['field'];
$table 		= $_GET['table'];
$id 		= (int) $_GET['id'];
$value_new	= mysqli_real_escape_string($link, $_GET['value_new']);

//Überprüfen, ob Zugriff auf Tabelle und Wert erlaubt ist
if (!(array_key_exists($table, $allowed) AND in_array($field, $allowed[$table]))){
	exit;
}

$query = sprintf('UPDATE %1$s SET %2$s="%4$s" WHERE id=%3$u;', $table, $field, $id, $value_new);
mysqli_query($link, $query) or die;

?>
