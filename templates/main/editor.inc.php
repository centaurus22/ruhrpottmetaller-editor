<form action="" method="get">
    <input type="hidden" name="show" value="events">
    <input type="hidden" name="save" value="concert">
    <input type="hidden" name="id" value="<?=$this->get('event')->getId()?>">
    <fieldset class="fieldset_general">
        <legend>General concert data</legend>
        <div>
            <div>
                <label for="name" class="edit_label">Name</label>
                <input type="text"
                    name="name"
                    id="name"
                    value="<?=$this->get('event')->getName()?>"
                    class="edit_text"
                    placeholder="Name of the concert">
            </div>
            <div>
                <label for="date_start" class="edit_label">Date*</label>
                <input type="date"
                    name="date_start"
                    id="date_start"
                    value="<?=$this->get('event')->getDate()->getFormatted() ?>"
                    class="edit_date"
                    required>
                <span aria-hidden="true">&nbsp;for&nbsp;</span>
                <label class="screen_reader_only" for="length">Number of days</label>
                <input type="number"
                    name="length"
                    id="length"
                    value="<?=$this->get('event')->getNumberOfDays()?>"
                    class="edit_length"
                    min="1">
                <span aria-hidden="true">&nbsp;day(s)</span>
            </div>
            <div id="ajax_city_venue"
                 data-venue-id="<?=$this->get('event')->getVenueId() ?? null ?>"
                 data-city-id="<?=$this->get('event')->getCityId()  ?? null ?>">
            </div>
            <div>
                <label for="url" class="edit_label">URL*</label>
                <input type="url"
                    name="url"
                    id="url"
                    class="edit_text"
                    value="<?=$this->get('event')->getUrl()?>"
                    placeholder="Link to more information"
                    required>
            </div>
        </div>
    </fieldset>
    <fieldset id="ajax_lineup" data-event-id="<?=$this->get('event')->getId()?>">
    </fieldset>
    <input class="button_save" type="submit" value="Save">
</form>
<script src="assets/js/editor.js"></script>
