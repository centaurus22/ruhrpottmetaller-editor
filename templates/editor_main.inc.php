<form action="" method="get">
    <input type="hidden" name="show" value="events">
    <input type="hidden" name="save" value="concert">
    <input type="hidden" name="id" value="<?=$this->get('event')->getId()?>">
    <fieldset class="fieldset_general">
        <legend>General concert data</legend>

        <label for="name" class="edit_label">Name</label>
        <input type="text"
            name="name"
            id="name"
            value="<?=$this->get('event')->getName()?>"
            class="edit_text"
            placeholder="Name of the concert"
        >
        <br>
        <label for="date_start" class="edit_label">Date*</label>
        <input type="date"
            name="date_start"
            id="date_start"
            value="<?=$this->get('event')->getDate()->getFormatted() ?>"
            required class="edit_date"
        >
        <span aria-hidden="true">&nbsp;for&nbsp;</span>
        <label class="screenreader_only" for="length">Number of days</label>
        <input type="number"
            name="length"
            id="length"
            value="<?=$this->get('event')->getNumberOfDays()?>"
            class="edit_length"
            min="1"
        >
        <span aria-hidden="true">&nbsp;day(s)</span>
        <br>
        <!--<label for="city_id" class="edit_label">City</label>
        <select name="city_id"
            id="city_id"
            class="edit_select"
            onchange="display_new_city_form(); display_new_venue_form();"
        >
<?php
$cities = $this->get('cities');


?>
        </select><br>-->
        <?php $venueId = $this->get('event')->getVenueId() ?>
        <?php $cityId = $this->get('event')->getCityId() ?>
        <span id="ajax_city_venue"
              data-venue-id="<?=$venueId->get() ?? null ?>"
              data-city-id="<?=$cityId->get() ?? null ?>">
        </span>
        <label for="url" class="edit_label">URL*</label>
        <input type="url"
            name="url"
            id="url"
            class="edit_text"
            value="<?=$this->get('event')->getUrl()?>"
            placeholder="Link to more information"
            required
        >
    </fieldset>
    <fieldset id="ajax_lineup">
    </fieldset>
    <input class="button_save" type="submit" value="Save">
    <input type="reset" value="Reset">
</form>
<script src="assets/js/editor.js"></script>
