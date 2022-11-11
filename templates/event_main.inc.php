<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;

?>
<div class="rm_table">
    <div class="rm_table_header">
        <?=RmString::new('Date')->asTableCell()?>
        <?=RmString::new('Name')->asTableCell()?>
        <?=RmString::new('Venue')->asTableCell()?>
        <?=RmString::new('Url')->asTableCell()?>
    </div>
    <?php while ($this->get('events')->hasCurrent()) : ?>
        <?php $event = $this->get('events')->getCurrent(); ?>
        <div class="rm_table_row">
            <?=$event->getFormattedDate()->asTableCell() ?>
            <?=$event->getName()->asTableCell() ?>
            <?=$event->getVenue()->asVenueAndCity()->asTableCell()?>
            <?=$event->getUrl()->asWwwUrl()->asTableCell()?>
        </div>
        <?php $this->get('events')->pointAtNext(); ?>
    <?php endwhile; ?>
</div>