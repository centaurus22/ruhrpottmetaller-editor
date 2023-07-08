<main id="main">
<?php

$data = $this->_['data_array'];
$data[] = array('ref' => 'display_filter', 'type' => 'hidden');
$data[] = array('ref' => 'month', 'type' => 'hidden');
$data[] = array('ref' => 'save', 'type' => 'hidden');
$data[] = array('name' => 'Admin', 'type' => 'button', 'description' => 'Save');

echo $this->_['filter_value_changer'];

echo '<div class="content content_small">';
if ($this->_['error_text'] != '') {
    printf('<div class="error">%1$s</div>' . "\n", $this->_['error_text']);
}

echo '<div class="table">
        <div class="thead">
            <div class="tr">';

foreach ($data as $field) {
    if ($field['type'] != 'hidden' and $field['type'] != 'hidden_save') {
        printf('<span class="td">%1$s</span>', $field['name']);
    }
}

echo "\t</div>
    </div>
    <div class=\"tbody\">\n";

foreach ($this->_['result'] as $datum) {
    echo "\t\t<form action=\"\" class=\"tr\">\n";
    foreach ($data as $field) {
        switch ($field['type']) {
            case 'bool':
                printf(
                    "\t\t\t" . '<span class="td">
                    <label for="%3$s">%2$s</label>
                    <select id="%3$s" name="%1$s">',
                    $field['ref'],
                    $field['description'],
                    $field['ref'] . '_' . $datum['id']
                );
                if ($datum[$field['ref']] == 1) {
                    echo '<option value="0">no</option>
                        <option value="1" selected>yes</option>';
                } else {
                    echo '<option value="0" selected>no</option>
                        <option value="1">yes</option>';
                }
                echo '</select></span>' . "\n";
                break;
            case 'button':
                printf(
                    "\t\t\t" . '<span class="td">
                    <button class="tbutton" type="submit">%1$s</button>
                    </span>' . "\n",
                    $field['description']
                );
                break;
            case 'hidden':
            //nobreak
            case 'hidden_save':
                switch ($field['ref']) {
                    case 'month':
                        $datum['month'] = $this->_['month'];
                        break;
                    case 'save':
                        $datum['save'] = $this->_['display'];
                        break;
                    case 'save_id':
                        $datum['save_id'] = $datum['id'];
                        break;
                    case 'display_filter':
                        $datum['display_filter'] = $this->_['filter_value'];
                }
                printf(
                    "\t\t\t<input type=\"hidden\" id=\"%3\$s\" value=\"%1\$s\" name=\"%2\$s\">\n",
                    htmlspecialchars($datum[$field['ref']], ENT_QUOTES),
                    $field['ref'],
                    $field['ref'] . '_' . $datum['id']
                );
                break;
            case 'string_display':
                printf(
                    "\t\t\t" . '<span class="td">%1$s</span>' . "\n",
                    htmlspecialchars($datum[$field['ref']], ENT_QUOTES)
                );
                break;
            case 'string_edit':
                //nobreak
            default:
                printf(
                    "\t\t\t" . '<span class="td">
                    <label for="%4$s">%3$s:</label>
                    <input class="tinputtext" type="text" id="%4$s" value="%1$s" name="%2$s" placeholder="%3$s">
                    </span>' . "\n",
                    htmlspecialchars($datum[$field['ref']] ?? '', ENT_QUOTES),
                    $field['ref'],
                    $field['description'],
                    $field['ref'] . '_' . $datum['id']
                );
                break;
        }
    }
    echo "\t\t</form>\n";
}

echo "\t\t</div>
    </div>
    </div>
    </main>\n";
