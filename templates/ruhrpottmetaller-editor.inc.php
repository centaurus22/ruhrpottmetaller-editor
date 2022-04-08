<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $this->_['pagetitle'] . $this->_['subtitle'] ?></title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
        <link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico" />
        <script  type="text/javascript" src="assets/js/script.js" ></script>
    </head>
    <body>
        <a class="skip-link" href="#main">Skip to content</a>
        <div class="leiste_top">
            <nav>
<?php

foreach ($this->_['menu_entrys'] as $menu_entry) {
    printf(
        "\t\t\t\t<a href='?display=%s&amp;month=%s'>%s</a>\n",
        $menu_entry[1],
        $this->_['month'],
        $menu_entry[0]
    );
}

?>
            </nav>
            <div class="noscript">
                <noscript>Please activate JavaScript!</noscript>
            </div>
        </div>
<?= $this->_['content']; ?>
        <footer>
            (c) Klaus Thorres 2020. This Software is provided under the <a href="?display=license">MIT License</a>.
        </footer>
    </body>
</html>
