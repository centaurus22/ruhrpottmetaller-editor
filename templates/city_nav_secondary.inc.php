<?php

use ruhrpottmetaller\Data\LowLevel\String\RmString;

?>

<form action="">
    <?=RmString::new('cities')
        ->asHiddenInput(RmString::new('show')) ?>
    <label for="filter_by">First char:</label> <select id="filter_by" name="filter_by">
        <option value=""></option>
        <?php while ($this->get('firstChars')->hasCurrent()) : ?>
            <?php $currentChar = $this->get('firstChars')->getCurrent() ?>
            <?php if ($currentChar == $this->get('filterByParameter')) : ?>
                <option value="<?=$currentChar?>" selected ="selected"><?=$currentChar?></option>
            <?php else : ?>
                <option value="<?=$currentChar?>"><?=$currentChar?></option>
            <?php endif; ?>
            <?php $this->get('firstChars')->pointAtNext() ?>
        <?php endwhile; ?>
    </select>
    <?=RmString::new('Filter')->asSubmitButton()?>
</form>