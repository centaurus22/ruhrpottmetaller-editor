<?php

$fieldset_name = "Preferences";

echo '<div id="inhalt" class="inhalt_large">
    <form action="" method="get">
        <fieldset class="fieldset_general">' . "\n";
printf("\t\t\t<legend>%1\$s</legend>", $fieldset_name);

foreach ($this->_['display_array'] as $field) {
    if ($field['type'] != 'hidden') {
        printf(
            '<label for="%1$s" class="edit_label">%2$s</label>' . "\n",
            $field['ref'],
            $field['name']
        );
    }

    switch($field['type']) {
        case 'hidden':
            printf(
                '<input type="hidden" name="%1$s" value="%2$s">',
                $field['ref'],
                $field['value']
            );
            break;
        case 'textarea':
            printf(
                '<textarea name="%1$s" id="%1$s">%3$s</textarea>',
                $field['ref'],
                $field['name'],
                $this->_['result'][0][$field['ref']]
            );
            break;
        case 'select':
            printf(
                '<select class="edit_select" name="%1$s" id="%1%s">',
                $field['ref'],
                $field['name']
            );
            foreach ($field['options'] as $value => $description) {
                if ($value == $this->_['result'][0][$field['ref']]) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                printf(
                    '<option value="%1$s" %3$s>%2$s</option>' . "\n",
                    $value,
                    $description,
                    $selected
                );
            }
            echo '</select>';
            break;
    }
    if ($field['type'] != 'hidden') {
        echo "<br>\n";
    }
}

echo '</fieldset>
    <input class="button_save" type="submit" value="Save">
    <input type="reset" value="Reset">
    </form>
    </div>' . "\n";
