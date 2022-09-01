<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\RmBool;

class Venue extends AbstractHighLevelDataObject implements IDataObject
{
    private City $City;
    private RmBool $IsVisible;

    public function setCity(City $City): Venue
    {
        $this->City = $City;
        return $this;
    }

    public function getCity(): City
    {
        return $this->City;
    }

    public function setIsVisible(RmBool $IsVisible): Venue
    {
        $this->IsVisible = $IsVisible;
        return $this;
    }

    public function getIsVisible(): RmBool
    {
        return $this->IsVisible;
    }
}