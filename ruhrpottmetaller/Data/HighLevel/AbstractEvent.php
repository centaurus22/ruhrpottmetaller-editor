<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;

class AbstractEvent extends AbstractHighLevelDataObject
{
    protected AbstractRmInt $NumberOfDays;
    protected Venue $Venue;
    protected AbstractRmString $Url;
    protected AbstractRmBool $IsSoldOut;
    protected AbstractRmBool $IsCanceled;

    public function setVenue(Venue $Venue): AbstractEvent
    {
        $this->Venue = $Venue;
        return $this;
    }

    public function getVenue(): Venue
    {
        return $this->Venue;
    }

    public function setUrl(AbstractRmString $Url): AbstractEvent
    {
        $this->Url = $Url;
        return $this;
    }

    public function getUrl(): AbstractRmString
    {
        return $this->Url;
    }

    public function setIsSoldOut(AbstractRmBool $IsSoldOut): AbstractEvent
    {
        $this->IsSoldOut = $IsSoldOut;
        return $this;
    }

    public function getIsSoldOut(): AbstractRmBool
    {
        return $this->IsSoldOut;
    }

    public function setIsCanceled(AbstractRmBool $IsCanceled): AbstractEvent
    {
        $this->IsCanceled = $IsCanceled;
        return $this;
    }

    public function getIsCanceled(): AbstractRmBool
    {
        return $this->IsCanceled;
    }
}
