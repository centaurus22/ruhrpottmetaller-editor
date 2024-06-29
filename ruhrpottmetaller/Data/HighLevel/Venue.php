<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class Venue extends AbstractNamedHighLevelData implements IData, IVenue
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

    public function getCityName(): AbstractRmString
    {
        return $this->city->getName();
    }

    public function getCityId(): AbstractRmInt
    {
        return $this->city->getId();
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

    public function getFormattedVenueAndCity(): AbstractRmString
    {
        if (!$this->city->getName()->isNull()) {
            return $this->getFormattedName()->concatWith(AbstractRmString::new(', '))
                ->concatWith($this->city->getFormattedName());
        }
        return $this->getFormattedName();
    }

    private function getFormattedName(): AbstractRmString
    {
        if ($this->isVisible->isTrue()) {
            return $this->name;
        }
        return RmString::new('<span class="invisible">' . $this->name->get() . '</span>');
    }
}
