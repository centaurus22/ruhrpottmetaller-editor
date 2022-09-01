<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\RmDate;
use ruhrpottmetaller\Data\LowLevel\RmInt;

class Festival extends AbstractEvent
{
    protected RmInt $NumberOfDays;
    protected RmDate $DateStart;


    public function setDateStart(RmDate $DateStart): Festival
    {
        $this->DateStart = $DateStart;
        return $this;
    }

    public function getDateStart(): RmDate
    {
        return $this->DateStart;
    }

    public function setNumberOfDays(RmInt $NumberOfDays): Festival
    {
        $this->NumberOfDays = $NumberOfDays;
        return $this;
    }

    public function getNumberOfDays(): RmInt
    {
        return $this->NumberOfDays;
    }
}
