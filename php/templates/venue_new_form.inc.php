<?php
if ($this->_['venue_id'] == 1):
?>
	<label for="venue_new_name" class="edit_text">New venue</label>
	<input type="text" name="venue_new_name" id="venue_new_name" class="edit_field" value="<?= $this->_['venue_new_name']?>" placeholder="Name of the new venue">
	<br>
	<label for="venue_url" class="edit_text">Standard URL</label>
	<input type="text" name="venue_url" id="venue_url" value="<?= $this->_['venue_url']?>" class="edit_field" placeholder="Standard URL of the venue">
	<br>
<?php
endif;
?>
