<?php

echo $this->_['month_changer'];
?>
<div id="inhalt" class="inhalt_small">
<?php
printf(
    '<a href="?edit=concert&amp;month=%1$s"><button>Add concert</button></a>',
    $this->_['month']
);
?>
</div>
