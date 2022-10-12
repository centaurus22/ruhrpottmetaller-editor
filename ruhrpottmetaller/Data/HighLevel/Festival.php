<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;

class Festival extends AbstractEvent
{
    protected AbstractRmInt $numberOfDays;
    protected RmDate $dateStart;

    public function setDateStart(RmDate $dateStart): Festival
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    public function getDateStart(): RmDate
    {
        return $this->dateStart;
    }

    public function setNumberOfDays(AbstractRmInt $numberOfDays): Festival
    {
        $this->numberOfDays = $numberOfDays;
        return $this;
    }

    public function getNumberOfDays(): AbstractRmInt
    {
        return $this->numberOfDays;
    }
}
