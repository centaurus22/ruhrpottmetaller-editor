<?php


$data = $this->Inner_View->assign('data_array', $data);
$data[] = array('ref' => 'month', 'type' => 'hidden');
$data[] = array('ref' => 'save', 'type' => 'hidden');
$data[] = array('ref' => 'save_id', 'type' => 'hidden');
$data[] = array('name' => 'Admin', 'type' => 'button', 'description' => 'Save');

echo $this->_['property_changer'];

echo '<div id="inhalt" class="inhalt_small">
    <div class="table">
        <div class="thead">
            <div class="tr">';

foreach ($data as $field) {
    if ($field['type'] != 'hidden') {
        printf('<span class="td">%1$s</span>', $field['name']);
    }
}

echo "\t</div>
    </div>
    <div class=\"tbody\">\n";

foreach($this->_['result'] as $datum) {
    echo "\t\t<form class=\"tr\">\n";
    foreach($data as $field) {
        switch($field['type']) {
            case 'bool':
                if ($datum[$field['ref']]) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                printf(
                    "\t\t\t" . '<span class="td">
                    <label for="%1$s" hidden>%3$s</label>
                        <input class="tinputcheckbox" type="checkbox" id="%1$s" name="%1$s" %2$s>
                    </span>' . "\n",
                    $field['ref'],
                    $checked,
                    $field['description']
                );
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
                switch($field['ref']){
                    case 'month':
                        $datum['month'] = $this->_['month'];
                    case 'save':
                        $datum['save'] = $this->_['display'];
                        break;
                    case 'save_id':
                        $datum['save_id'] = $datum['id'];
                        break;
                }
                printf(
                    "\t\t\t<input type=\"hidden\" id=\"%2\$s\" value=\"%1\$s\" name=\"%2\$s\">\n",
                    htmlspecialchars($datum[$field['ref']], ENT_QUOTES),
                    $field['ref']
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
                    <label for="%2$s" hidden>%3$s</label>
                    <input class="tinputtext" type="text" id="%2$s" value="%1$s" name="%2$s" placeholder="%3$s">
                    </span>' . "\n",
                    htmlspecialchars($datum[$field['ref']], ENT_QUOTES),
                    $field['ref'],
                    $field['description']
                );
                break;
        }
    }
    echo "\t\t</form>\n";
}

echo "\t\t</div>
    </div>
    </div>\n";
