<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\RmString;

class MenuEntry extends AbstractHighLevelDataObject
{
    public function print()
    {
        printf(
            '<li><a href="?display=%1$s">%2$s</a></li>',
            $this->getId()->get(),
            $this->getName()->get()
        );
    }
}