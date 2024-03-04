<?php $cities = $this->get('cities'); ?>
<div>
    <label for="city_id" class="edit_label">City</label>
    <select id="city_id" name="city_id">
        <option value="0"></option>
        <?php while ($cities->hasCurrent()) : ?>
            <?php $cityId = $cities->getCurrent()->getId()->get(); ?>
            <?php $cityName = $cities->getCurrent()->getName()->get(); ?>
            <?php if ($this->get('cityId')->get() == $cities->getCurrent()->getId()->get()) : ?>
                <?=printf(
                    '<option value="%1$u" selected="selected">%2$s</option>',
                    $cityId,
                    $cityName
                );?>
            <?php else : ?>
                <option value="<?=$cityId?>"><?=$cityName?></option>
            <?php endif; ?>
            <?php $cities->pointAtNext(); ?>
        <?php endwhile; ?>
    </select>
</div>
<?php if ($this->get('getNewCity')->isFalse()) : ?>
    <?php $venues = $this->get('venues'); ?>
    <div>
        <label for="venue_id" class="edit_label">Venue</label>
        <select id="venue_id" name="venue_id">
            <?php while ($venues->hasCurrent()) : ?>
                <?php $venueId = $venues->getCurrent()->getId()->get(); ?>
                <?php $venueName = $venues->getCurrent()->getName()->get(); ?>
                <?php if ($this->get('venueId')->get() == $venues->getCurrent()->getId()->get()) : ?>
                    <?=printf(
                        '<option value="%1$u" selected="selected">%2$s</option>',
                        $venueId,
                        $venueName
                    );?>
                <?php else : ?>
                    <option value="<?=$venueId?>"><?=$venueName?></option>
                <?php endif; ?>
                <?php $venues->pointAtNext(); ?>
            <?php endwhile; ?>
        </select>
    </div>
<?php endif; ?>
<?php if ($this->get('getNewVenue')->isTrue()) : ?>
    <div>
         <label for="venue_new_name" class="edit_label">New venue</label>
         <input type="text"
             name="venue_new_name"
             id="venue_new_name"
             class="edit_text"
             placeholder="Name of the new venue">
    </div>
    <div>
        <label for="url_default" class="edit_label">Default URL</label>
        <input type="text"
         name="url_default"
         id="url_default"
         class="edit_text"
         placeholder="Default URL of the venue">
    </div>
<?php endif; ?>
