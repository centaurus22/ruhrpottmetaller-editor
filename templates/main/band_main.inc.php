<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;

?>
<div class="rm_table">
    <div class="rm_table_header">
        <?=RmString::new('Name')->asTableCell()?>
        <?=RmString::new('Visible')->asTableCell()?>
        <?=RmString::new('')->asTableCell()?>
    </div>
    <?php while ($this->get('bands')->hasCurrent()) : ?>
        <?php $data = $this->get('bands')->getCurrent(); ?>
        <form action="" class="rm_table_row">
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
                )
                ->asTableCell() ?>
            <?=RmString::new('bands')
                ->asHiddenInput(RmString::new('show')) ?>
            <?=RmString::new('band')
                ->asHiddenInput(RmString::new('save')) ?>
            <?=$this->get('filterByParameter')
                ->asHiddenInput(RmString::new('filter_by')) ?>
            <?=$data->getId()->asHiddenInput(RmString::new('id')) ?>
            <?=RmString::new('Save')->asSubmitButton()->asTableCell()?>
        </form>
        <?php $this->get('bands')->pointAtNext(); ?>
    <?php endwhile; ?>
</div>