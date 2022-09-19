<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\AbstractRmString;

class Venue extends AbstractHighLevelDataObject implements IDataObject
{
    private City $City;
    private AbstractRmBool $IsVisible;

    public function setCity(City $City): Venue
    {
        $this->City = $City;
        return $this;
    }

    public function getCity(): City
    {
        return $this->City;
    }

    public function setIsVisible(AbstractRmBool $IsVisible): Venue
    {
        $this->IsVisible = $IsVisible;
        return $this;
    }

    public function getIsVisible(): AbstractRmBool
    {
        return $this->IsVisible;
    }

    public function combineVenueAndCityName(): Venue
    {
        $this->Name->concatWith(AbstractRmString::new(', '))->concatWith($this->City->getName());
        return $this;
    }
}