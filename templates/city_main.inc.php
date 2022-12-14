<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;

?>
<div class="rm_table">
    <div class="rm_table_header">
        <?=RmString::new('Name')->asTableCell()?>
        <?=RmString::new('Visible')->asTableCell()?>
    </div>
    <?php while ($this->get('cities')->hasCurrent()) : ?>
        <?php $data = $this->get('cities')->getCurrent(); ?>
        <div class="rm_table_row">
            <?=$data->getName()
                ->asTableInput(
                    RmString::new('name'),
                    RmString::new('Name'),
                    $data->getId()
                )
                ->asTableCell() ?>
            <?=$data->getIsVisible()
                ->asTableInput(
                    RmString::new('is_visible'),
                    RmString::new('Visible'),
                    $data->getId()
                )->asTableCell() ?>
        </div>
        <?php $this->get('cities')->pointAtNext(); ?>
    <?php endwhile; ?>
</div>