<?= $this->_['month_changer'] ?>
<div id="inhalt" class="inhalt_small">
	<table id="data">
		<tr>
			<th></th>
			<th class="concerts_table_date">Date</th>
			<th>Name</th>
			<th>Venue</th>
			<th>Bands</th>
			<th>URL</th>
			<th>Admin</th>
		</tr>
<?php

foreach($this->_['concerts'] as $concert) {
	//Build the list of bands
	$bands = '';
	foreach($concert['bands'] as $band) {
		if ($band['zusatz']) {
			$bands = $bands . sprintf(', <span class="%3$s">%1$s (%2$s)</span>', 
				htmlspecialchars($band['name'], ENT_QUOTES),
				htmlspecialchars($band['zusatz'], ENT_QUOTES),
				htmlspecialchars($band['nazi'], ENT_QUOTES));
		}
		else {
			$bands = $bands . sprintf(', <span class="%2$s">%1$s</span>', 
				htmlspecialchars($band['name'], ENT_QUOTES),
				htmlspecialchars($band['nazi'], ENT_QUOTES));
		}
	}
	$bands = substr($bands, 2);
	printf("\t\t<tr class='%1\$s_oben'>
			<td><a href=\"#\" onclick=\"display_concert(%10\$u)\" >
				<img src=\"%11\$s\" alt=\"open export\" />
			</a></td>
			<td>%2\$s</td>
			<td>%3\$s</td>
			<td>%4\$s, %5\$s</td>
			<td>%7\$s</td>
			<td><a class='%1\$s' href='%6\$s'>%6\$s</a></td>
			<td class=\"table_buttons\">
				<form action=\"\" method=\"GET\" id=\"%10\$u\">
					<select name=\"special\">
						<option value=\"add_concert\">Add</option>
						<option value=\"edit_concert\">Edit</option>
						<option value=\"published\">Published</option>
						<option value=\"del_concert\">Del</option>
						<option value=\"sold_out\">Sold Out</option>
					</select>
					<input type=\"hidden\" name=\"month\" value=\"%9\$s\">
					<input type=\"hidden\" name=\"id\" value=\"%10\$u\">
					<input type=\"hidden\" name=\"date\" value=\"%8\$s\">
					<button type=\"submit\" form=\"%10\$u\">Ok</button>
				</form>
			</td>
		</tr>
		<tr class='%1\$s_unten'>
			<td></td>
			<td id=\"concert_%10\$s\" colspan=\"7\"></td>
		</tr>\n", htmlspecialchars($concert['status'], ENT_QUOTES), $concert['date_human'],
			htmlspecialchars($concert['kname'], ENT_QUOTES), 
			htmlspecialchars($concert['lname'], ENT_QUOTES),
			htmlspecialchars($concert['sname'], ENT_QUOTES), 
			htmlspecialchars($concert['url'], ENT_QUOTES), $bands, $concert['datum_beginn'], $this->_['month'],
			$concert['id'], $this->_['image_path'] . DIRECTORY_SEPARATOR . 'plus_small.png');
}
?>
	</table>
</div>
