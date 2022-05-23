<?php

namespace ruhrpottmetaller\DataSet;

use ruhrpottmetaller\DataType\DataTypeInt;
use ruhrpottmetaller\DataType\DataTypeDate;

abstract class AbstractFestivalDataSet extends AbstractEventDataSet
{
    protected DataTypeInt $NumberOfDays;
    protected DataTypeDate $DateStart;


    public function setDateStart(DataTypeDate $DateStart): void
    {
        $this->DateStart = $DateStart;
    }

    public function getDateStart(): DataTypeDate
    {
        return $this->DateStart;
    }

    public function setNumberOfDays(DataTypeInt $NumberOfDays): void
    {
        $this->NumberOfDays = $NumberOfDays;
    }

    public function getNumberOfDays(): DataTypeInt
    {
        return $this->NumberOfDays;
    }
}
