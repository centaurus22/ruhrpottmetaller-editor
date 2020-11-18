<?php

switch($this->_['display']) {
    case 'city':
        $data = array (
            1 => array(
                'name' => 'Name',
                'ref' => 'name',
                'type' => 'string',
                'description' => 'Name of the city'
            ),
            2 => array(
                'name' => 'Admin',
                'type' => 'button',
                'description' => 'Save'
            )
        );
        break;
    case 'venue':
        $data = array (
            1 => array(
                'name' => 'Name',
                'ref' => 'name',
                'type' => 'string_edit',
                'description' => 'Name of the venue'
            ),
            2 => array(
                'name' => 'City',
                'ref' => 'city_name',
                'type' => 'string_display'
            ),
            3 => array(
                'name' => 'Standard URL',
                'ref' => 'url',
                'type' => 'string_edit',
                'description' => 'Standard URL of the venue'
            ),
            4 => array(
                'name' => 'Export',
                'ref' => 'anzeigen',
                'type' => 'bool',
                'description' => 'Export'
            ),
            5 => array(
                'name' => 'Admin',
                'type' => 'button',
                'description' => 'Save'
            )
        );
        break;
    case 'band':
        $data = array (
            1 => array(
                'name' => 'Name',
                'ref' => 'name',
                'type' => 'string',
                'description' => 'Name of the Band'
            ),
            2 => array(
                'name' => 'Nazi',
                'ref' => 'nazi',
                'type' => 'bool',
                'description' => 'Nazi band'
            ),
            3 => array(
                'name' => 'Admin',
                'type' => 'button',
                'description' => 'Save'
            )
        );
        break;
}

echo $this->_['property_changer'];

echo '<div class="inhalt_small">
    <div class="table">
        <div class="tr">';

foreach ($data as $field) {
   printf('<span class="td">%1$s</span>', $field['name']);
}

echo "</div>\n";

foreach($this->_['result'] as $datum) {
    echo "\t\t<form class=\"tr\">\n";
    foreach($data as $field) {
        echo '<span class="td">';
        switch($field['type']) {
            case 'bool':
                if ($datum[$field['ref']]) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                printf(
                    '<input type="checkbox" id="%1$s" name="%1$s" %2$s>',
                    $field['ref'],
                    $checked
                );
                break;
            case 'button':
                printf(
                    '<button type="submit">%1$s</button>',
                    $field['description']
                );
                break;
            case 'string_display':
                echo htmlspecialchars($datum[$field['ref']], ENT_QUOTES);
                break;
            case 'string_edit':
            default:
                printf(
                    '<input type="text" id="%2$s" value="%1$s" name="%2$s" placeholder="%3$s">',
                    htmlspecialchars($datum[$field['ref']], ENT_QUOTES),
                    $field['ref'],
                    $field['description']
                );
                break;
        }
        echo "</span>\n";
    }
    echo "\t\t</form>\n";
}

echo "</div>
    </div>\n";
