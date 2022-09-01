<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\RmDate;

class Concert extends AbstractEvent
{
    protected RmDate $Date;

    public function setDate(RmDate $Date): Concert
    {
        $this->Date = $Date;
        return $this;
    }

    public function getDate(): RmDate
    {
        return $this->Date;
    }
}
