<?php

foreach ($this->_['bands'] as $band) {
    if ($band['id'] == $this->_['band_id']) {
        printf(
            "\t\t\t" . '<option value="%1$s" selected>%2$s</option>' . "\n",
            $band['id'],
            htmlspecialchars($band['name'], ENT_QUOTES)
        );
    } else {
        printf(
            "\t\t\t" . '<option value="%1$s">%2$s</option>' . "\n",
            $band['id'],
            htmlspecialchars($band['name'], ENT_QUOTES)
        );
    }
}
