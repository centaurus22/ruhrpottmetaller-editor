<div class="rm_table">
    <?php while ($this->get('events')->hasCurrent()) : ?>
        <?php $event = $this->get('events')->getCurrent(); ?>
        <div class="rm_table_row">
            <?=$event->getName()->asTableCell() ?>
            <?=$event->getFormattedDate()->asTableCell() ?>
            <?=$event->getVenue()->asVenueAndCity()->asTableCell()?>
            <?=$event->getUrl()->asWwwUrl()->asTableCell()?>
        </div>
        <?php $this->get('events')->pointAtNext(); ?>
    <?php endwhile; ?>
</div>