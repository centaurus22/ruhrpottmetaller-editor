<?php

if (isset($this->_['header'])) {
	echo $this->_['month_changer'];
	echo '<div id="inhalt" class="inhalt_small">';
	echo nl2br(htmlspecialchars($this->_['header'], ENT_QUOTES));
}

foreach($this->_['concerts'] as $concert) {
	//Build the list of bands
	$bands = '';
	foreach($concert['bands'] as $band) {
		if ($band['zusatz'] != '') {
			$bands = $bands . sprintf('%1$s (%2$s), ', 
				htmlspecialchars($band['name'], ENT_QUOTES),
				htmlspecialchars($band['zusatz'], ENT_QUOTES));
		}
		else {
			$bands = $bands . sprintf('%1$s, ', 
				htmlspecialchars($band['name'], ENT_QUOTES));
		}
	}
	$bands = substr($bands, 0, -2);
	echo '<p>* ';
	if ($concert['ausverkauft'] == 1) {
		echo '(ausverkauft) ';
	}	
	$concert['date_human'] . ': ';
	if ($concert['kname']) {
		echo htmlspecialchars($concert['kname'], ENT_QUOTES) . ', ';
	}
	echo ' ' . htmlspecialchars($concert['lname'], ENT_QUOTES) . ' in  ' . 
		htmlspecialchars($concert['sname'], ENT_QUOTES) . ".<br/>";
	echo $bands . '.<br/>';	
	echo htmlspecialchars($concert['url'], ENT_QUOTES) . "</p>\n";
}

if (isset($this->_['header'])) {
	echo nl2br(htmlspecialchars($this->_['footer'], ENT_QUOTES));
	echo '</div>';
}
?>
