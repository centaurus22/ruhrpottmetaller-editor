<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;

?>

<form action="">
    <?=RmString::new('venues')
        ->asHiddenInput(RmString::new('show')) ?>
    <label for="filter_by">City:</label> <select id="filter_by" name="filter_by">
        <option value="">&nbsp;</option>
        <?php while ($this->get('cities')->hasCurrent()) : ?>
            <?php $currentCity = $this->get('cities')->getCurrent()->getName()->get() ?>
            <?php if ($currentCity == $this->get('filterByParameter')) : ?>
                <option value="<?=$currentCity?>" selected="selected"><?=$currentCity?></option>
            <?php else : ?>
                <option value="<?=$currentCity?>"><?=$currentCity?></option>
            <?php endif; ?>
            <?php $this->get('cities')->pointAtNext() ?>
        <?php endwhile; ?>
    </select>
    <?=RmString::new('Filter')->asSubmitButton()?>
</form>