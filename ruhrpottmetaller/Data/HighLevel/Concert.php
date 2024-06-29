<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Bool\RmFalse;
use ruhrpottmetaller\Data\LowLevel\Bool\RmTrue;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;

class Concert extends Event
{
    protected RmDate $date;

    public function setDate(RmDate $date): Concert
    {
        $this->date = $date;
        return $this;
    }

    public function getDate(): RmDate
    {
        return $this->date;
    }

    public function getNumberOfDays(): AbstractRmInt
    {
        return RmInt::new(1);
    }

    public function getFormattedDate(): AbstractRmString
    {
        return $this->date->getFormatted('D, d.');
    }

    public function isFestival(): AbstractRmBool
    {
        return RmFalse::new(false);
    }
}
