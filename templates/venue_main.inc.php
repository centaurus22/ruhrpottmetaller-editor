<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;

?>
<div class="rm_table">
    <div class="rm_table_header">
        <?=RmString::new('Name')->asTableCell()?>
        <?=RmString::new('City')->asTableCell()?>
        <?=RmString::new('Default Url')->asTableCell()?>
        <?=RmString::new('Visible')->asTableCell()?>
    </div>
    <?php while ($this->get('venues')->hasCurrent()) : ?>
        <?php $data = $this->get('venues')->getCurrent(); ?>
        <div class="rm_table_row">
            <?=$data->getName()
                ->asTableInput(
                    RmString::new('name'),
                    RmString::new('Name'),
                    $data->getId()
                )->asTableCell() ?>
            <?=$data->getCity()->getName()->asTableCell() ?>
            <?=$data->getUrlDefault()
                ->asTableInput(
                    RmString::new('url_default'),
                    RmString::new('Default Url'),
                    $data->getId()
                )->asTableCell() ?>
            <?=$data->getIsVisible()
                ->asTableInput(
                    RmString::new('is_visible'),
                    RmString::new('Visible'),
                    $data->getId()
                )
                ->asTableCell() ?>
        </div>
        <?php $this->get('venues')->pointAtNext(); ?>
    <?php endwhile; ?>
</div>