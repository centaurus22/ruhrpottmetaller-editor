<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;

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
}
