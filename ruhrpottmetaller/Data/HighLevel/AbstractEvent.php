<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\RmBool;
use ruhrpottmetaller\Data\LowLevel\RmInt;
use ruhrpottmetaller\Data\LowLevel\RmString;

class AbstractEvent
{
    protected RmInt $Id;
    protected RmString $Name;
    protected RmInt $NumberOfDays;
    protected RmString $VenueName;
    protected RmString $CityName;
    protected RmString $Url;
    protected RmBool $IsSoldOut;
    protected RmBool $IsCanceled;

    public static function new()
    {
        return new static();
    }

    public function setId(RmInt $Id): AbstractEvent
    {
        $this->Id = $Id;
        return $this;
    }

    public function getId(): RmInt
    {
        return $this->Id;
    }

    public function setName(RmString $Name): AbstractEvent
    {
        $this->Name = $Name;
        return $this;
    }

    public function getName(): RmString
    {
        return $this->Name;
    }

    public function setVenueName(RmString $VenueName): AbstractEvent
    {
        $this->VenueName = $VenueName;
        return $this;
    }

    public function getVenueName(): RmString
    {
        return $this->VenueName;
    }

    public function setCityName(RmString $CityName): AbstractEvent
    {
        $this->CityName = $CityName;
        return $this;
    }

    public function getCityName(): RmString
    {
        return $this->CityName;
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
