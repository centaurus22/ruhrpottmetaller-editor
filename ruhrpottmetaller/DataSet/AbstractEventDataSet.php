<?php

namespace ruhrpottmetaller\DataSet;

use ruhrpottmetaller\DataType\DataTypeInt;
use ruhrpottmetaller\DataType\DataTypeString;
use ruhrpottmetaller\DataType\DataTypeBool;

abstract class AbstractEventDataSet
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

    public function setId(DataTypeInt $Id): void
    {
        $this->Id = $Id;
    }

    public function getId(): DataTypeInt
    {
        return $this->Id;
    }

    public function setName(DataTypeString $Name): void
    {
        $this->Name = $Name;
    }

    public function getName(): DataTypeString
    {
        return $this->Name;
    }

    public function setVenueName(DataTypeString $VenueName): void
    {
        $this->VenueName = $VenueName;
    }

    public function getVenueName(): DataTypeString
    {
        return $this->VenueName;
    }

    public function setCityName(DataTypeString $CityName): void
    {
        $this->CityName = $CityName;
    }

    public function getCityName(): DataTypeString
    {
        return $this->CityName;
    }

    public function setUrl(DataTypeString $Url): void
    {
        $this->Url = $Url;
    }

    public function getUrl(): DataTypeString
    {
        return $this->Url;
    }

    public function setIsSoldOut(DataTypeBool $IsSoldOut): void
    {
        $this->IsSoldOut = $IsSoldOut;
    }

    public function getIsSoldOut(): DataTypeBool
    {
        return $this->IsSoldOut;
    }

    public function setIsCanceled(DataTypeBool $IsCanceled): void
    {
        $this->IsCanceled = $IsCanceled;
    }

    public function getIsCanceled(): DataTypeBool
    {
        return $this->IsCanceled;
    }
}
