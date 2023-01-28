<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\RmArray;

abstract class AbstractEvent extends AbstractNamedHighLevelData
{
    protected AbstractRmInt $numberOfDays;
    protected RmArray $bands;
    protected IVenue $venue;
    protected AbstractRmString $url;
    protected AbstractRmBool $isSoldOut;
    protected AbstractRmBool $isCanceled;

    public function __construct()
    {
        $this->bands = RmArray::new();
    }

    public function setVenue(IVenue $venue): AbstractEvent
    {
        $this->venue = $venue;
        return $this;
    }

    public function setUrl(AbstractRmString $url): AbstractEvent
    {
        $this->url = $url;
        return $this;
    }

    public function getUrl(): AbstractRmString
    {
        return $this->url;
    }

    public function setIsSoldOut(AbstractRmBool $isSoldOut): AbstractEvent
    {
        $this->isSoldOut = $isSoldOut;
        return $this;
    }

    public function getIsSoldOut(): AbstractRmBool
    {
        return $this->isSoldOut;
    }

    public function setIsCanceled(AbstractRmBool $isCanceled): AbstractEvent
    {
        $this->isCanceled = $isCanceled;
        return $this;
    }

    public function getIsCanceled(): AbstractRmBool
    {
        return $this->isCanceled;
    }

    public function getVenueAndCityName(): AbstractRmString
    {
        return $this->venue->asVenueAndCity();
    }

    public function addBands(RmArray $bands): AbstractEvent
    {
        $this->bands = $bands;
        return $this;
    }

    public function getCurrentBand(): Band
    {
        return $this->bands->getCurrent();
    }

    public function hasCurrentBand(): bool
    {
        return $this->bands->hasCurrent();
    }

    public function pointAtNextBand(): AbstractEvent
    {
        $this->bands->pointAtNext();
        return $this;
    }
}
