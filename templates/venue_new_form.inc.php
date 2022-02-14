<?php if ($this->_['venue_id'] == 1) : ?>
    <label for="venue_new_name" class="edit_label">New venue</label>
    <input type="text"
        name="venue_new_name"
        id="venue_new_name"
        class="edit_text"
        value="<?= $this->_['venue_new_name']?>"
        placeholder="Default URL of the new venue"
    >
    <br>
    <label for="venue_url" class="edit_label">Default URL</label>
    <input type="text" 
        name="venue_url"
        id="venue_url"
        value="<?= $this->_['venue_url']?>"
        class="edit_text"
        placeholder="Standard URL of the venue"
    >
    <br>
<?php endif; ?>
