<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;

class Venue extends AbstractHighLevelData implements IData, IVenue
{
    private ICity $city;
    private AbstractRmString $urlDefault;
    private AbstractRmBool $isVisible;

    public function setCity(ICity $city): Venue
    {
        $this->city = $city;
        return $this;
    }

    public function getCity(): ICity
    {
        return $this->city;
    }

    public function setUrlDefault(AbstractRmString $urlDefault): IVenue
    {
        $this->urlDefault = $urlDefault;
        return $this;
    }

    public function getUrlDefault(): AbstractRmString
    {
        return $this->urlDefault;
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
