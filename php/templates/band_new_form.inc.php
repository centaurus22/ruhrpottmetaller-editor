<?php
printf("\t\t\t" . '<label for="band_new_name_%1$u" hidden>New band</label>' . "\n", $this->_['row']);

if ($this->_['band_id'] == 3) {
	printf("\t\t\t" . '<input type="text" name="band_new_name[]" value="%2$s" id="band_new_name_%1$u" class="edit_field" placeholder="Name of the new Band" onchange="save_band_lineup(%1$u, %1$u, \'band_new_name\')" autocomplete="off"/>' . "\n",
		$this->_['row'], $this->_['band_new_name']);
} else {
	printf("\t\t\t" . '<input type="hidden" name="band_new_name[]" value="%2$s" id="band_new_name_%1$u" class="edit_field" placeholder="Name of the new Band" onchange="save_band_lineup(%1$u, %1$u, \'band_new_name\')" autocomplete="off"/>' ."\n",
		$this->_['row'], $this->_['band_new_name']);
}
