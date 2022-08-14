<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\DataTypeBool;
use ruhrpottmetaller\Data\LowLevel\DataTypeInt;
use ruhrpottmetaller\Data\LowLevel\DataTypeString;

class AbstractEvent
{
    protected DataTypeInt $Id;
    protected DataTypeString $Name;
    protected DataTypeInt $NumberOfDays;
    protected DataTypeString $VenueName;
    protected DataTypeString $CityName;
    protected DataTypeString $Url;
    protected DataTypeBool $IsSoldOut;
    protected DataTypeBool $IsCanceled;

    public static function new()
    {
        return new static();
    }

    public function setId(DataTypeInt $Id): AbstractEvent
    {
        $this->Id = $Id;
        return $this;
    }

    public function getId(): DataTypeInt
    {
        return $this->Id;
    }

    public function setName(DataTypeString $Name): AbstractEvent
    {
        $this->Name = $Name;
        return $this;
    }

    public function getName(): DataTypeString
    {
        return $this->Name;
    }

    public function setVenueName(DataTypeString $VenueName): AbstractEvent
    {
        $this->VenueName = $VenueName;
        return $this;
    }

    public function getVenueName(): DataTypeString
    {
        return $this->VenueName;
    }

    public function setCityName(DataTypeString $CityName): AbstractEvent
    {
        $this->CityName = $CityName;
        return $this;
    }

    public function getCityName(): DataTypeString
    {
        return $this->CityName;
    }

    public function setUrl(DataTypeString $Url): AbstractEvent
    {
        $this->Url = $Url;
        return $this;
    }

    public function getUrl(): DataTypeString
    {
        return $this->Url;
    }

    public function setIsSoldOut(DataTypeBool $IsSoldOut): AbstractEvent
    {
        $this->IsSoldOut = $IsSoldOut;
        return $this;
    }

    public function getIsSoldOut(): DataTypeBool
    {
        return $this->IsSoldOut;
    }

    public function setIsCanceled(DataTypeBool $IsCanceled): AbstractEvent
    {
        $this->IsCanceled = $IsCanceled;
        return $this;
    }

    public function getIsCanceled(): DataTypeBool
    {
        return $this->IsCanceled;
    }
}
