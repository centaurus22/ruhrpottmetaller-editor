<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\RmBool;
use ruhrpottmetaller\Data\LowLevel\RmInt;
use ruhrpottmetaller\Data\LowLevel\RmString;

class AbstractEvent extends AbstractHighLevelDataObject
{
    protected RmInt $NumberOfDays;
    protected Venue $Venue;
    protected RmString $Url;
    protected RmBool $IsSoldOut;
    protected RmBool $IsCanceled;

    public function setVenue(Venue $Venue): AbstractEvent
    {
        $this->Venue = $Venue;
        return $this;
    }

    public function getVenue(): Venue
    {
        return $this->Venue;
    }

    public function setUrl(RmString $Url): AbstractEvent
    {
        $this->Url = $Url;
        return $this;
    }

    public function getUrl(): RmString
    {
        return $this->Url;
    }

    public function setIsSoldOut(RmBool $IsSoldOut): AbstractEvent
    {
        $this->IsSoldOut = $IsSoldOut;
        return $this;
    }

    public function getIsSoldOut(): RmBool
    {
        return $this->IsSoldOut;
    }

    public function setIsCanceled(RmBool $IsCanceled): AbstractEvent
    {
        $this->IsCanceled = $IsCanceled;
        return $this;
    }

    public function getIsCanceled(): RmBool
    {
        return $this->IsCanceled;
    }
}
