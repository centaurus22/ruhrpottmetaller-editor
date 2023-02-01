<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;

?>
<div class="rm_table">
    <div class="rm_table_header">
        <?=RmString::new('Date')->asTableCell()?>
        <?=RmString::new('Name')->asTableCell()?>
        <?=RmString::new('Venue')->asTableCell()?>
        <?=RmString::new('Bands')->asTableCell()?>
        <?=RmString::new('Url')->asTableCell()?>
        <?=RmString::new('')->asTableCell()?>
    </div>
    <?php while ($this->get('events')->hasCurrent()) : ?>
        <?php $event = $this->get('events')->getCurrent(); ?>
        <form action="" class="rm_table_row">
            <?=RmString::new('events')
                ->asHiddenTableInput(RmString::new('show')) ?>
            <?=RmString::new('event')
                ->asHiddenTableInput(RmString::new('modify')) ?>
            <?=$event->getId()->asHiddenTableInput(RmString::new('id'))?>
            <?=$event->getDate()->getFormatted()->asHiddenTableInput(RmString::new('date'))?>
            <?=$event->getFormattedDate()->asTableCell() ?>
            <?=$event->getName()->asTableCell() ?>
            <?=$event->getVenueAndCityName()->asTableCell()?>
            <?=$event->getBandList()?>
            <?=$event->getUrl()->asWwwUrl()->asTableCell()?>
            <?=RmString::new('<select name="action">
                <option value="add">Add</option>
                <option value="edit">Edit</option>
                <option value="delete">Delete</option>
                <option value="sold_out">Set sold out</option>
            </select>')->concatWith(RmString::new('Do It')->asSubmitButton())->asTableCell()?>
        </form>
        <?php $this->get('events')->pointAtNext(); ?>
    <?php endwhile; ?>
</div>