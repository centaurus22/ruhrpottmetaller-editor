<?php
//Wenn über so eine Methode in einer Datenbanktabelle Änderungen durchgeführt werden,
//muss auf jeden Fall genau geprüft werden, ob das Feld so auch überschrieben werden darf,
//weil sonst wichtige Daten zerstört werden könnten.

//array mit erlaubten Zugriffsmöglichkeiten
$allowed = array(
	'preferences' => array('header', 'footer')
);

//verschiedene tests durchführen, ob der Aufruf legal ist
if (!isset($_POST['field']) OR !isset($_POST['table']) OR !isset($_POST['value_new'])) {
	exit;
}

$field = $_POST['field'];
$table = $_POST['table'];
$value_new = $_POST['value_new'];

//Überprüfen, ob Zugriff auf Tabelle und Wert erlaubt ist
if (!(array_key_exists($table, $allowed) AND in_array($field, $allowed[$table]))){
	exit;
}
require('connect.php');
$value_new = mysqli_real_escape_string($link, $value_new);
$query = sprintf('UPDATE %1$s SET %2$s="%3$s";', $table, $field, $value_new);
mysqli_query($link, $query) or die;

?>
