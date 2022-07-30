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

    public static function new(): AbstractEventDataSet
    {
        return new static();
    }

    public function setId(DataTypeInt $Id): AbstractEventDataSet
    {
        $this->Id = $Id;
        return $this;
    }

    public function getId(): DataTypeInt
    {
        return $this->Id;
    }

    public function setName(DataTypeString $Name): AbstractEventDataSet
    {
        $this->Name = $Name;
        return $this;
    }

    public function getName(): DataTypeString
    {
        return $this->Name;
    }

    public function setVenueName(DataTypeString $VenueName): AbstractEventDataSet
    {
        $this->VenueName = $VenueName;
        return $this;
    }

    public function getVenueName(): DataTypeString
    {
        return $this->VenueName;
    }

    public function setCityName(DataTypeString $CityName): AbstractEventDataSet
    {
        $this->CityName = $CityName;
        return $this;
    }

    public function getCityName(): DataTypeString
    {
        return $this->CityName;
    }

    public function setUrl(DataTypeString $Url): AbstractEventDataSet
    {
        $this->Url = $Url;
        return $this;
    }

    public function getUrl(): DataTypeString
    {
        return $this->Url;
    }

    public function setIsSoldOut(DataTypeBool $IsSoldOut): AbstractEventDataSet
    {
        $this->IsSoldOut = $IsSoldOut;
        return $this;
    }

    public function getIsSoldOut(): DataTypeBool
    {
        return $this->IsSoldOut;
    }

    public function setIsCanceled(DataTypeBool $IsCanceled): AbstractEventDataSet
    {
        $this->IsCanceled = $IsCanceled;
        return $this;
    }

    public function getIsCanceled(): DataTypeBool
    {
        return $this->IsCanceled;
    }
}
