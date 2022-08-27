<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\RmString;

class MenuEntry extends AbstractHighLevelDataObject
{
    public function print(RmString $month)
    {
        printf(
            '<li><a href="?display=%1$s&amp;month=%2$s">%3$s</a></li>',
            $this->getId()->get(),
            $month->get(),
            $this->getName()->get()
        );
    }
}