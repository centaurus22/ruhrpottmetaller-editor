<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class Concert extends AbstractEvent
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

    public function getFormattedDate(): AbstractRmString
    {
        return $this->date->getFormatted('D, d.');
    }
}
