<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;

class Band extends AbstractHighLevelDataObject implements IDataObject
{
    private AbstractRmBool $IsVisible;

    public function setIsVisible(AbstractRmBool $IsVisible)
    {
        $this->IsVisible = $IsVisible;
    }

    public function getIsVisible(): AbstractRmBool
    {
        return $this->IsVisible;
    }
}