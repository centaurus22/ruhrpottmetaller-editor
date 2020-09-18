<div id="inhalt" class="inhalt_large">
    <form action="" method="get">
        <input type="hidden" name="display" value="concert">
        <input type="hidden" name="save" value="concert">
<?php
if (isset($this->_['request']['edit_id'])) {
    printf("\t\t" . '<input type="hidden" name="save_id" value="%1$u">',
        $this->_['request']['edit_id']);
}
?>
        <fieldset>
            <legend>General concert data</legend>
<?php
if ($this->_['error_text'] != '') {
    echo "\t\t\t<p class=\"error\">" . $this->_['error_text'] . "</p>\n";
}
?>

            <label for="name" class="edit_text">Name</label>
            <input type="text" name="name" id="name" value="<?=$this->_['request']['name']?>" class="edit_field" placeholder="Name of the concert">
            <br>
            <label for="date_start" class="edit_text">Date*</label>
            <input type="date" name="date_start" id="date_start" value="<?=$this->_['request']['date_start']?>" required class="edit_field">
            <label for="length">for</label>
            <input type="number" name="length" id="length" value="<?=$this->_['request']['length']?>" class="edit_field" min="1">day(s)<br>
            <label for="city_id" class="edit_text">City</label>
            <select name="city_id" id="city_id" value="<?=$this->_['request']['city_id']?>" onchange="display_city_venue_form(); display_venue_new_form();">
<?php
foreach ($this->_['cities'] as $city) {
    if ($this->_['request']['city_id'] == $city['id'] ) {
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
            <label for="url" class="edit_text">URL*</label>
            <input type="url" name="url" id="url" class="edit_field" value="<?=$this->_['request']['url']?>" placeholder="Link to more information" required/><br>
        </fieldset>
        <fieldset id="lineup">
            <?= $this->_['lineup'] ?>
        </fieldset>
        <input type="submit" value="Save">
        <input type="reset" value="Reset">
    </form>
</div>
