<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class Venue extends AbstractHighLevelDataObject implements IDataObject
{
    private City $city;
    private AbstractRmBool $isVisible;

    public function setCity(City $city): Venue
    {
        $this->city = $city;
        return $this;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function setIsVisible(AbstractRmBool $isVisible): Venue
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    public function getIsVisible(): AbstractRmBool
    {
        return $this->isVisible;
    }

    public function asVenueAndCity(): AbstractRmString
    {
        if (!$this->city->getName()->isNull()) {
            return $this->name->concatWith(AbstractRmString::new(', '))
                ->concatWith($this->city->getName());
        }
        return $this->name;
    }
}
