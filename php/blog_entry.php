<?php
if (isset($_GET['text']) AND isset($_GET['ueberschrift']) AND isset($_GET['id']))
{
	include('connect.php');
	$text = mysqli_real_escape_string($link, $_GET['text']);
	$ueberschrift = mysqli_real_escape_string($link, $_GET['ueberschrift']);
	$id = (int) $_GET['id'];
	$query = sprintf('UPDATE blog SET ueberschrift = "%s", text = "%s" WHERE id = %u;',
		$ueberschrift, $text, $id);
	mysqli_query($link, $query);
	
}

if (isset($_GET['id']))
{
	/*	Wenn die GET-Variable "id" gesetzt ist, heißt das, dass die Datei von einer java-script-funktion
		aufgerufen wird und die benötigten Daten noch aus der Datenbank geholt werden müssen.
		Wenn die GET-Variable nicht gesetzt ist, ist die Datei included und die Daten stehen schon zur Verfügung */
	$id = (int) $_GET['id'];
	require_once('connect.php');
	$query = sprintf('SELECT id, ueberschrift, zeit, text, sticky FROM blog WHERE id = %u', $id);
	$result = mysqli_query($link, $query);
	$nachricht = mysqli_fetch_array($result);
}

$checkboxarray = array('', 'checked="checked"');
printf("<div id=\"nachricht_%s\" class=\"blog_beitrag\">\n", $id);
printf("\t<h1 class=\"blog_ueberschrift\">%s</h1>\n", htmlspecialchars($nachricht['ueberschrift'], ENT_QUOTES));
printf("\t<div class=\"datum\" >%s</div>\n", htmlspecialchars($nachricht['zeit'], ENT_QUOTES);
printf("\t<div class=\"blog_text\">%s</div>\n", htmlspecialchars($nachricht['text'], ENT_QUOTES));
printf("<button type=\"button\" onclick=\"edit_blog_entry('%2\$u')\">Edit</button> Sticky:<input %1\$s type=\"checkbox\" onchange=\"change_binary_row('blog', 'sticky', '%2\$u')\" />\n",
	$checkboxarray[$nachricht['sticky']], $id);
echo "</div>\n";
?>
