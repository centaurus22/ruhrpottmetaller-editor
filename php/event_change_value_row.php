<?php

//Wenn über so eine Methode in einer Datenbanktabelle Änderungen durchgeführt werden,
//muss auf jeden Fall genau geprüft werden, ob das Feld so auch überschrieben werden darf,
//weil sonst wichtige Daten zerstört werden könnten.

//array mit erlaubten Zugriffsmöglichkeiten
$allowed = array(
	'event'		=> array('ausverkauft', 'publiziert'),
);

//verschiedene tests durchführen, ob der Aufruf legal ist
if (!(isset($field) AND isset($table) AND isset($_GET['id']) AND isset($value_new))) {
	exit;
}


//Überprüfen, ob Zugriff auf Tabelle und Wert erlaubt ist
if (!(array_key_exists($table, $allowed) AND in_array($field, $allowed[$table]))){
	exit;
}

require_once('connect.php');
$id = (int) $_GET['id'];
$value_new = mysqli_real_escape_string($link, $value_new);

$query = sprintf('UPDATE %1$s SET %2$s="%4$s" WHERE id=%3$u;', $table, $field, $id, $value_new);
mysqli_query($link, $query) or die;

?>
