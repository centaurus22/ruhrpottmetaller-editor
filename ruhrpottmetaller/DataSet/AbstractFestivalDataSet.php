<?php

namespace ruhrpottmetaller\DataSet;

use ruhrpottmetaller\DataType\DataTypeInt;
use ruhrpottmetaller\DataType\DataTypeDate;

abstract class AbstractFestivalDataSet extends AbstractEventDataSet
{
    protected DataTypeInt $NumberOfDays;
    protected DataTypeDate $DateStart;


    public function setDateStart(DataTypeDate $DateStart): AbstractFestivalDataSet
    {
        $this->DateStart = $DateStart;
        return $this;
    }

    public function getDateStart(): DataTypeDate
    {
        return $this->DateStart;
    }

    public function setNumberOfDays(DataTypeInt $NumberOfDays): AbstractFestivalDataSet
    {
        $this->NumberOfDays = $NumberOfDays;
        return $this;
    }

    public function getNumberOfDays(): DataTypeInt
    {
        return $this->NumberOfDays;
    }
}
