<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class City extends AbstractNamedHighLevelData implements IData, ICity
{
    private AbstractRmBool $isVisible;

    public function getIsVisible(): AbstractRmBool
    {
        return $this->isVisible;
    }

    public function setIsVisible(AbstractRmBool $isVisible): City
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    public function getFormattedName(): AbstractRmString
    {
        if ($this->isVisible->isTrue()) {
            return $this->name;
        }
        return RmString::new('<span class="invisible">' . $this->name . '</span>');
    }
}
