<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;

class Band extends AbstractHighLevelDataObject implements IDataObject
{
    private AbstractRmBool $isVisible;

    public function setIsVisible(AbstractRmBool $isVisible): Band
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    public function getIsVisible(): AbstractRmBool
    {
        return $this->isVisible;
    }
}
