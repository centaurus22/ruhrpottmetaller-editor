<legend>Concert lineup</legend>
<?php
if (isset($this->_['error']) and $this->_['error'] != '') {
    echo '<p class="error">' . $this->_['error_text'] . '</p>';
}
$alphabet = range('A', 'Z');
array_splice($alphabet, 0, 0, '');
$alphabet[] = '%';
for (
    $lineup_index = 0;
    $lineup_index < count($this->_['lineup']);
    $lineup_index++
) {
    printf(
        "\t\t<fieldset class=\"fieldset_band\">\n\t\t" . '<legend>Band %1$s</legend>
        <label for="first_sign_%1$u" class="screenreader_only">First letter the of the band name</label>
        <select  id="first_sign_%1$u" name="first_sign[]" onchange="save_band_lineup(\'%1$u\', \'first_sign\'); get_band_select_options(\'%1$u\')" autocomplete="off">' . "\n",
        $lineup_index
    );
    foreach ($alphabet as $first_sign) {
        if ($this->_['lineup'][$lineup_index]['first_sign'] == $first_sign) :
            printf(
                "\t\t\t<option selected value=\"%1\$s\">%1\$s</option>\n",
                $first_sign
            );
        else :
            printf(
                "\t\t\t<option value=\"%1\$s\">%1\$s</option>\n",
                $first_sign
            );
        endif;
    }
    printf(
        "\t\t" . '</select>
        <label for="band_id_%1$u" class="screenreader_only">Band Id</label>
        <select name="band_id[]" id="band_id_%1$u" onchange="save_band_lineup(\'%1$u\', \'band_id\'); get_band_new_form(\'%1$u\')" autocomplete="off" class="edit_band_id">' . "\n",
        $lineup_index
    );
    echo $this->_['band_select_options'][$lineup_index];
    printf("\t\t </select>
        <span id=\"band_new_form_%1\$u\">\n", $lineup_index);
    echo $this->_['band_new_form'][$lineup_index];
    $addition = $this->_['lineup'][$lineup_index]['addition'];
    printf(
        "\t\t" . '</span>
        <label for="addition_%1$u" class="screenreader_only">Addition</label>
        <input type="text" name="addition[]" value="%4$s" id="addition_%1$u" class="edit_field" placeholder="Extra information" onchange="save_band_lineup(\'%1$u\', \'addition\')" autocomplete="off"/>
        <button type="button" onclick="set_band_lineup(\'%2$u\')">
            <img src="%3$s/plus_small.png" alt="Add band to lineup" width="15" height="15"/>
        </button>
        <button type="button" onclick="del_band_lineup(\'%1$u\')"><img src="%3$s/minus_small.png" alt="Remove band from lineup" width="15" height="15"/></button>
        <button type="button" onclick="shift_band_lineup(\'%1$u\', \'up\')">
            <img src="%3$s/arrow_up_small.png" width="15" height="15" alt="Shift %1$s. band one line up">
        </button>
        <button type="button" onclick="shift_band_lineup(\'%1$u\', \'down\')">
            <img src="%3$s/arrow_down_small.png" alt="Shift %1$s. one line down" width="15" height="15">
        </button>' . "\n\t\t</fieldset>\n\n",
        $lineup_index,
        $lineup_index + 1,
        $this->image_path,
        htmlspecialchars($addition, ENT_QUOTES)
    );
}
?>
