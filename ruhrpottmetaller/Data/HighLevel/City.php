<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;

class City extends AbstractHighLevelDataObject implements IDataObject
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
