<?php

namespace ruhrpottmetaller\Data;

use ruhrpottmetaller\DataType\DataTypeInt;
use ruhrpottmetaller\DataType\DataTypeDate;

class Festival extends AbstractEvent
{
    protected DataTypeInt $NumberOfDays;
    protected DataTypeDate $DateStart;


    public function setDateStart(DataTypeDate $DateStart): Festival
    {
        $this->DateStart = $DateStart;
        return $this;
    }

    public function getDateStart(): DataTypeDate
    {
        return $this->DateStart;
    }

    public function setNumberOfDays(DataTypeInt $NumberOfDays): Festival
    {
        $this->NumberOfDays = $NumberOfDays;
        return $this;
    }

    public function getNumberOfDays(): DataTypeInt
    {
        return $this->NumberOfDays;
    }
}
