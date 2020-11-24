<?php

if (isset($this->_['header'])) {
    echo $this->_['month_changer'];
    echo '<div id="inhalt" class="inhalt_small">';
    echo nl2br(htmlspecialchars($this->_['header'], ENT_QUOTES));
} else {
    printf(
        '<div class="titlebar">
            <a href="#" class="close_button" onclick="remove_concert(%1$u)">×</a>
        </div>
        <div class="content">',
        $this->_['concerts'][0]['id']
    );

}

foreach($this->_['concerts'] as $concert) {
    if (
        !isset($this->_['header'])
        or (isset($this->_['header'])
        and !isset($concert['nazi']))
    ) {
        //Build the list of bands
        $bands = '';
        foreach($concert['bands'] as $band) {
            if ($band['zusatz'] != '') {
                $bands = $bands . sprintf('%1$s (%2$s), ',
                    htmlspecialchars($band['name'], ENT_QUOTES),
                    htmlspecialchars($band['zusatz'], ENT_QUOTES));
            }
            else {
                $bands = $bands . sprintf('%1$s, ',
                    htmlspecialchars($band['name'], ENT_QUOTES));
            }
        }
        $bands = substr($bands, 0, -2);
        echo "<p ondblclick=\"selectElmCnt(this)\">* ";
        if ($concert['ausverkauft'] == 1) {
            echo '(ausverkauft) ';
        }
        echo $concert['date_human'] . ':';
        if ($concert['name']) {
            echo ' ' . htmlspecialchars($concert['name'], ENT_QUOTES) . ', ';
        }
        if ($concert['venue_name'] == '') {
            echo '<br>';
        } else {
            echo ' ' . htmlspecialchars($concert['venue_name'], ENT_QUOTES) . ' in  ' .
            htmlspecialchars($concert['city_name'], ENT_QUOTES) . "<br>";
        }
        if ($bands != '') {
            echo '&nbsp;&nbsp;' . $bands . '.<br>';
        }
        $url = htmlspecialchars($concert['url'], ENT_QUOTES);
        echo '&nbsp;&nbsp;' . $url . "</p>\n";
    }
}

if (isset($this->_['header'])) {
    echo nl2br(htmlspecialchars($this->_['footer'], ENT_QUOTES));
}
echo '</div>';
