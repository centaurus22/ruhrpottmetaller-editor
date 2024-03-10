<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;

?>
<div class="rm_table">
    <div class="rm_table_header">
        <?=RmString::new('Name')->asTableCell()?>
        <?=RmString::new('Visible')->asTableCell()?>
        <?=RmString::new('')->asTableCell()?>
    </div>
    <?php while ($this->get('cities')->hasCurrent()) : ?>
        <?php $data = $this->get('cities')->getCurrent(); ?>
        <form action="" class="rm_table_row">
            <?=$data->getName()
                ->filter()
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
            <?=$data->getId()->asHiddenInput(RmString::new('id')) ?>
            <?=RmString::new('cities')
                ->asHiddenInput(RmString::new('show')) ?>
            <?=RmString::new('city')
                ->asHiddenInput(RmString::new('save')) ?>
            <?=$this->get('filterByParameter')
                ->asHiddenInput(RmString::new('filter_by')) ?>
            <?=RmString::new('Save')->asSubmitButton()->asTableCell()?>
        </form>
        <?php $this->get('cities')->pointAtNext(); ?>
    <?php endwhile; ?>
</div>