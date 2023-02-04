<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;

?>
<div class="rm_table">
    <div class="rm_table_header">
        <?=RmString::new('Name')->asTableCell()?>
        <?=RmString::new('City')->asTableCell()?>
        <?=RmString::new('Default Url')->asTableCell()?>
        <?=RmString::new('Visible')->asTableCell()?>
        <?=RmString::new('')->asTableCell()?>
    </div>
    <?php while ($this->get('venues')->hasCurrent()) : ?>
        <?php $data = $this->get('venues')->getCurrent(); ?>
        <form action="" class="rm_table_row">
            <?=RmString::new('venues')
                ->asHiddenInput(RmString::new('show')) ?>
            <?=RmString::new('venue')
                ->asHiddenInput(RmString::new('save')) ?>
            <?=$data->getId()->asHiddenTableInput(RmString::new('id')) ?>
            <?=$data->getName()
                ->asTableInput(
                    RmString::new('name'),
                    RmString::new('Name'),
                    $data->getId()
                )->asTableCell() ?>
            <?=$data->getCityName()->asTableCell() ?>
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
            <?=RmString::new('Save')->asSubmitButton()->asTableCell()?>
        </form>
        <?php $this->get('venues')->pointAtNext(); ?>
    <?php endwhile; ?>
</div>