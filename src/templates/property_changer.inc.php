<?php

echo '<form method="get" action=?"' . http_build_query($this->_['request']) . '">';
switch($this->_['property_type']) {
    case 'first_char':
        echo '<select name="display_first_char">';
        break;
    case 'city':
        echo '<select name="display_city_id">';
        break;
}

foreach($this->_['property_selector_list'] AS $id => $name) {
    if ($name == $this->_['property_selector']) {
        $option_string = '<option value="%1$s" selected>%2$s</option>' . "\n";
    } else {
        $option_string = '<option value="%1$s">%2$s</option>' . "\n";
    }
    printf($option_string, $id, $name);
}
echo '</select>' . "\n" . '</form>';
