<p>

<?php
foreach($this->_['concerts'] as $concert) {
	//Build the list of bands
	$bands = '';
	foreach($concert['bands'] as $band) {
		if ($band[1]) {
			$bands = $bands . sprintf('%1$s (%2$s), ', 
				htmlspecialchars($band[0], ENT_QUOTES),
				htmlspecialchars($band[2], ENT_QUOTES));
		}
		else {
			$bands = $bands . sprintf('%1$s, ', 
				htmlspecialchars($band[0], ENT_QUOTES));
		}
	}
	$bands = substr($bands, 0, -2);
	echo '* '. $concert['date_human'] . ': ';
	if ($concert['kname']) {
		echo htmlspecialchars($concert['kname'], ENT_QUOTES) . ', ';
	}
	echo ' ' . htmlspecialchars($concert['lname'], ENT_QUOTES) . ' in  ' . 
		htmlspecialchars($concert['sname'], ENT_QUOTES) . ".<br/>";
	echo $bands . '.<br/>';	
	echo htmlspecialchars($concert['url'], ENT_QUOTES);
}

?>

</p>
