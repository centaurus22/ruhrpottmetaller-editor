<?php
if ($this->_['city_id'] == 1):
?>
    <label for="city_new_name" class="edit_text">New city</label>
    <input type="text" name="city_new_name" id="city_new_name" value="<?=$this->_['city_new_name']?>" class="edit_field" placeholder="Name of the new city">
    <br>
<?php
else:
    if ($this->_['city_id'] > 1) {
        $this->_['venues'][] = array('id' => 1, 'name' => 'New venue');
    }
    echo "\t\t\t\t" . '<label for="venue_id" class="edit_text">Venue</label>
                <select name="venue_id" id="venue_id" onchange="display_venue_new_form()">' . "\n";
    foreach ($this->_['venues'] AS $venue) {
        if( $venue['id'] == $this->_['venue_id'] ) {
            printf("\t\t\t\t\t" . '<option value="%1$s" selected>%2$s</option>' . "\n",
                $venue['id'], htmlspecialchars($venue['name'], ENT_QUOTES));
        } else {
            printf("\t\t\t\t\t" . '<option value="%1$s">%2$s</option>' . "\n",
                $venue['id'], htmlspecialchars($venue['name'], ENT_QUOTES));
        }
    }
    echo "\t\t\t\t</select><br>\n";
endif;
?>
