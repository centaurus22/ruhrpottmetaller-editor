<!DOCTYPE html>
<html lang="en">
    <head>
        <?=$this->get('eventHeadDisplayControllerOutput')?>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="assets/css/base_style.css">
        <link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico">
    </head>
    <body>
        <a class="skip-link" href="#main">Skip to content</a>
        <nav>
            <ul>
<?php

while ($this->get('menu')->hasCurrent()) {
    printf(
        '<li><a href="?display=%1$s">%1$s</a></li>',
        $this->get('menu')->getCurrent()->get()
    );
    $this->get('menu')->pointAtNext();
}

?>
            </ul>
        </nav>
        <footer>
            Ruhrpottmetaller-Editor (c) Klaus Thorres 2022.
            This Software is provided under the <a href="?display=license">MIT License</a>.
        </footer>
    </body>
</html>
