<!DOCTYPE html>
<html>
    <head>
        <title><?= $this->_['pagetitle'].$this->_['subtitle'] ?></title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="includes/style.css" />
        <link rel="icon" type="image/vnd.microsoft.icon" href="includes/favicon.ico" />
        <script  type="text/javascript" src="includes/script.js" ></script>
    </head>
    <body>
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
        </div>
<?= $this->_['content']; ?>
        <div class="leiste_bottom">
            (c) Klaus Thorres 2020. This Software is provided under the <a href="?display=license">MIT License</a>.
        </div>
    </body>
</html>
