<?php $bands = $this->get('bands'); ?>
<?php while ($bands->hasCurrent()) : ?>
    <?php $band = $bands->getCurrent(); ?>
    <?php if ($this->get('bandId')->get() == $band->getId()->get()) : ?>
        <option value="<?=$band->getId()?>" selected><?=$band->getName()?></option>
    <?php else : ?>
        <option value="<?=$band->getId()?>"><?=$band->getName()?></option>
    <?php endif; ?>
    <?php $bands->pointAtNext(); ?>
<?php endwhile; ?>
