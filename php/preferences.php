<div id="inhalt" class="inhalt_large">

<?php
//Einstellungen aus Datenbank abrufen
$query="SELECT at, twitter, facebook, header, footer FROM preferences;";
$result=mysqli_query($link, $query);
//Variablen generieren, damit sie später nur geändert werden müssen, wenn sie aktiv sind.
$at = '';
$twitter  = '';
$facebook  = '';
$header = '';
$footer = '';
//Wenn keine Daten abgerufen worden sind, Standard-Einstellungen generieren.
if (!mysqli_num_rows($result)) {
	$query_gen = "INSERT INTO preferences VALUES (0, 0, 1, '', '');";
	mysqli_query($link, $query) or die ('Standardwerte konnten nicht eingespeichert werden.');
	$facebook = 'checked="checked"';
} else {
	$row = mysqli_fetch_array($result);
	if ($row['at']) {
		$at = 'checked="checked"';
	}
	if ($row['twitter']) {
		$twitter = 'checked="checked"';
	}
	if ($row['facebook']) {
		$facebook = 'checked="checked"';
	}
	$header = htmlspecialchars($row['header'], ENT_QUOTES);
	$footer = htmlspecialchars($row['footer'], ENT_QUOTES);
}

?>
<table id="data">
	<tr>
		<td><input type="checkbox" id="at" name="at" <?=$at?> onchange="change_binary('preferences', 'at')" /></td>
		<td><label for="at">Bei der Facebook-Nachricht ein "@" vor den Bandnamen schreiben.</label></td>
	</tr>
	<tr>
		<td><input type="checkbox" id="twitter" name="twitter" <?=$twitter?> onchange="change_binary('preferences', 'twitter')" /></td>
		<td><label for="twitter">Twitter-Nachricht generieren.</label></td>
	</tr>
	<tr>
	 	<td><input type="checkbox" id="facebook" name="facebook" <?=$facebook?> onchange="change_binary('preferences', 'facebook')" /></td>
		<td><label for="facebook">Facebook-Nachricht generieren.</label></td>
	</tr>
</table>
<p>
	<label for="header">Header für den Export:</label><br />
	<textarea id="header" name="header" rows="20" cols="80"
	onchange="change_value('preferences', 'header')"><?=$header?></textarea>
</p>
<p>		
	<label for="footer">Footer für den Export:</label><br />
	<textarea id="footer" name="footer" rows="20" cols="80"
	onchange="change_value('preferences', 'footer')"><?=$footer?></textarea>
</p>
</div>
