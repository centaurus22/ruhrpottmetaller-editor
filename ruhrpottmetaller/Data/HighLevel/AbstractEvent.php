<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;

class AbstractEvent extends AbstractHighLevelDataObject
{
    protected AbstractRmInt $numberOfDays;
    protected Venue $venue;
    protected AbstractRmString $url;
    protected AbstractRmBool $isSoldOut;
    protected AbstractRmBool $isCanceled;

    public function setVenue(Venue $venue): AbstractEvent
    {
        $this->venue = $venue;
        return $this;
    }

    public function getVenue(): Venue
    {
        return $this->venue;
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
}
