<main id="main" class="content content_large">
    <form action="" method="get">
        <input type="hidden" name="display" value="concert">
        <input type="hidden" name="save" value="concert">
<?php
if (isset($this->_['request']['edit_id'])) {
    printf(
        "\t\t" . '<input type="hidden" name="save_id" value="%1$u">',
        $this->_['request']['edit_id']
    );
}
?>
        <fieldset class="fieldset_general">
            <legend>General concert data</legend>
<?php
if ($this->_['error_text'] != '') {
    echo "\t\t\t<p class=\"error\">" . $this->_['error_text'] . "</p>\n";
}
?>

            <label for="name" class="edit_label">Name</label>
            <input type="text"
                name="name"
                id="name"
                value="<?=$this->_['request']['name']?>"
                class="edit_text"
                placeholder="Name of the concert"
            >
            <br>
            <label for="date_start" class="edit_label">Date*</label>
            <input type="date"
                name="date_start"
                id="date_start"
                value="<?=$this->_['request']['date_start']?>"
                required class="edit_date"
            >
            <span aria-hidden="true">&nbsp;for&nbsp;</span>
            <label class="screenreader_only" for="length">Number of days</label>
            <input type="number"
                name="length" 
                id="length" 
                value="<?=$this->_['request']['length']?>"
                class="edit_length"
                min="1"
            >
            <span aria-hidden="true">&nbsp;day(s)</span>
            <br>
            <label for="city_id" class="edit_label">City</label>
            <select name="city_id"
                id="city_id"
                class="edit_select"
                onchange="display_new_city_form(); display_new_venue_form();"
            >
<?php
foreach ($this->_['cities'] as $city) {
    if ($this->_['request']['city_id'] == $city['id']) {
        printf(
            "\t\t\t\t" . '<option value="%1$u" selected>%2$s</option>' . "\n",
            $city['id'],
            $city['name']
        );
    } else {
        printf(
            "\t\t\t\t" . '<option value="%1$u">%2$s</option>' . "\n",
            $city['id'],
            $city['name']
        );
    }
}
?>
            </select><br>
            <span id="city_venue_form">
<?= $this->_['city_venue_form'] ?>
            </span>
            <span id="venue_new_form">
            <?=$this->_['venue_new_form'] ?>
            </span>
            <label for="url" class="edit_label">URL*</label>
            <input type="url" 
                name="url"
                id="url"
                class="edit_text"
                value="<?=$this->_['request']['url']?>" 
                placeholder="Link to more information"
                required
            >
        </fieldset>
        <fieldset id="lineup">
            <?= $this->_['lineup'] ?>
        </fieldset>
        <input class="button_save" type="submit" value="Save">
        <input type="reset" value="Reset">
    </form>
</main>
