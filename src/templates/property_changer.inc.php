<div id="leiste_buttons">
<?php

echo "\t" . '<form method="get" action="" >' . "\n";

$this->takeOverRequestParameters('month');
$this->takeOverRequestParameters('display');

switch($this->_['property_type']) {
    case 'first_char':
        echo "\t\t<select name=\"display_first_char\">\n";
        break;
    case 'city':
        echo "\t\t<select name=\"display_city_id\">\n";
        break;
}

foreach($this->_['property_selector_list'] as $id => $name) {
    if ($id == $this->_['property_selector']) {
        $option_string = "\t\t\t" . '<option value="%1$s" selected>%2$s</option>' . "\n";
    } else {
        $option_string = "\t\t\t" . '<option value="%1$s">%2$s</option>' . "\n";
    }
    printf($option_string, $id, $name);
}
echo "\t\t</select>\n\t\t<button type=\"submit\">Display</button>\n\t</form>";

?>

</div>
