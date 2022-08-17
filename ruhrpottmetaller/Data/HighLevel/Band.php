<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\RmBool;

class Band extends AbstractHighLevelDataObject implements IDataObject
{
    private RmBool $IsVisible;

    public function setIsVisible(RmBool $IsVisible)
    {
        $this->IsVisible = $IsVisible;
    }

    public function getIsVisible(): RmBool
    {
        return $this->IsVisible;
    }
}