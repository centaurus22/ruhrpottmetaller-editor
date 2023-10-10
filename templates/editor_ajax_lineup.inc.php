<legend>Concert lineup</legend>

<?php

$alphabet = range('A', 'Z');
array_splice($alphabet, 0, 0, '');
$alphabet[] = '%';
$lineupIndex = 1;

?>

<?php while ($this->get('gigs')->hasCurrent()): ?>
    <?php $gig = $this->get('gigs')->getCurrent() ?>
    <fieldset class="fieldset_band">
        <legend>Band <?=$lineupIndex?></legend>
        <label for="first_sign_<?=$lineupIndex?>" class="screen_reader_only">First letter the of the band name</label>
        <select  id="first_sign_<?=$lineupIndex?>" name="first_sign[]" autocomplete="off">
            <!--onchange="save_band_lineup(\'%1$u\', \'first_sign\'); get_band_select_options(\'%1$u\')"-->

            <?php foreach ($alphabet as $firstSign): ?>
                <?php if ($gig->getBandFirstChar()->get() == $firstSign) : ?>
                    <option value="<?=$firstSign?>" selected><?=$firstSign?></option>
                <?php else : ?>
                    <option value="<?=$firstSign?>"><?=$firstSign?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <label for="band_id_<?=$lineupIndex?>" class="screen_reader_only">Band</label>
        <select name="band_id[]" id="band_id_<?=$lineupIndex?>" autocomplete="off" class="edit_band_id">
            <!-- onchange="save_band_lineup(\'%1$u\', \'band_id\'); get_band_new_form(\'%1$u\')" -->
            <!-- echo $this->_['band_select_options'][$lineup_index]; -->
        </select>
        <span id="band_new_form_<?=$lineupIndex?>">
            <!--echo $this->_['band_new_form'][$lineup_index];-->
        </span>
        <label for="addition_<?=$lineupIndex?>" class="screen_reader_only">Addition</label>
        <input type="text" 
            name="addition[]"
            value="<?=$gig->getAdditionalInformation()?>"
            id="addition_<?=$lineupIndex?>"
            class="edit_field"
            placeholder="Extra information">
        <!-- onchange="save_band_lineup(\'%1$u\', \'addition\')" autocomplete="off" -->
        <button type="button" onclick="add_band_lineup(\'%2$u\')">
            <img src="<?=$this->get('imagePath')?>plus_small.png"
                 alt="Add band to lineup"
                 width="15"
                 height="15">
        </button>
        <button type="button" onclick="del_band_lineup(\'%1$u\')">
            <img src="<?=$this->get('imagePath')?>minus_small.png"
                 alt="Remove band <?=$lineupIndex?> from lineup"
                 width="15"
                 height="15">
        </button>
        <button type="button" onclick="shift_band_lineup(\'%1$u\', \'up\')">
            <img src="<?=$this->get('imagePath')?>arrow_up_small.png"
                 alt="Shift <?=$lineupIndex?>. band one line up"
                 width="15"
                 height="15">
        </button>
        <button type="button" onclick="shift_band_lineup(\'%1$u\', \'down\')">
            <img src="<?=$this->get('imagePath')?>arrow_down_small.png"
                 alt="Shift <?=$lineupIndex?>. Band one line down"
                 width="15"
                 height="15">
        </button>
    </fieldset>
    <?php $this->get('gigs')->pointAtNext(); ?>
    <?php $lineupIndex++; ?>
<?php endwhile; ?>