<?php $cities = $this->get('cities'); ?>
<label for="city_id" class="edit_label">City</label>
<select id="city_id" name="city_id">
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
<?php if ($this->get('getNewCity')->isFalse()) : ?>
    <br>
    <?php $venues = $this->get('venues'); ?>
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
<?php endif; ?>
<?php if ($this->get('getNewVenue')->isTrue()) : ?>
    <br>
     <label for="venue_new_name" class="edit_label">New venue</label>
     <input type="text"
         name="venue_new_name"
         id="venue_new_name"
         class="edit_text"
         placeholder="Name of the new venue"
     >
     <br>
     <label for="default_url" class="edit_label">Default URL</label>
     <input type="text"
         name="default_url"
         id="default_url"
         class="edit_text"
         placeholder="Default URL of the venue"
    >
<?php endif; ?>
