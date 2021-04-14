<main id="main">

<?php

echo $this->_['month_changer'];

echo "\t" . '<div class="content content_small">';

printf(
    '<a href="?edit=concert&amp;month=%1$s"><button>Add concert</button></a>',
    $this->_['month']
);
?>

    </div>
</main>

