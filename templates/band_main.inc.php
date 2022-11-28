<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;

?>
<div class="rm_table">
    <div class="rm_table_header">
        <?=RmString::new('Name')->asTableCell()?>
        <?=RmString::new('Visible')->asTableCell()?>
    </div>
    <?php while ($this->get('bands')->hasCurrent()) : ?>
        <?php $event = $this->get('bands')->getCurrent(); ?>
        <div class="rm_table_row">
            <?=$event->getName()->asTableCell() ?>
            <?=$event->getIsVisible()->asTableCell() ?>
        </div>
        <?php $this->get('bands')->pointAtNext(); ?>
    <?php endwhile; ?>
</div>