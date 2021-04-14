<?php

$fieldset_name = "Preferences";

echo '<main id="main" class=" content content_large">
    <form action="" method="get">
        <fieldset class="fieldset_general">' . "\n";

if ($this->_['error_text'] != '') {
    echo "\t\t\t<p class=\"error\">" . $this->_['error_text'] . "</p>\n";
}

printf("\t\t\t<legend>%1\$s</legend>", $fieldset_name);

foreach ($this->_['data_array'] as $field) {
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
            $value = $this->_['result'][0][$field['ref']];
            printf(
                '<textarea name="%1$s" id="%1$s">%3$s</textarea>',
                $field['ref'],
                $field['name'],
                htmlspecialchars($value, ENT_QUOTES)
            );
            break;
        case 'select':
            printf(
                '<select class="edit_select" name="%1$s" id="%1$s">',
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
    </main>' . "\n";
