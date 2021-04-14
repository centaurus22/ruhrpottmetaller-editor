<div id="leiste_buttons">
<?php

echo "\t" . '<form method="get" action="" >' . "\n";

$this->takeOverRequestParameters('month');
$this->takeOverRequestParameters('display');

echo "\t\t<label for=\"display_filter\" class=\"screenreader_only\">Filter value</label>
    <select id=\"display_filter\"  name=\"display_filter\">\n";

foreach($this->_['filter_value_list'] as $id => $name) {
    if ($id == $this->_['filter_value']) {
        $option_string = "\t\t\t" . '<option value="%1$s" selected>%2$s</option>' . "\n";
    } else {
        $option_string = "\t\t\t" . '<option value="%1$s">%2$s</option>' . "\n";
    }
    printf($option_string, $id, $name);
}
echo "\t\t</select>\n\t\t<button type=\"submit\">Display</button>\n\t</form>";

?>

</div>
