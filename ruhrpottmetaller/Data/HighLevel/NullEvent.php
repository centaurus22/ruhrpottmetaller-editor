<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\Int\RmNullInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmNullString;

class NullEvent extends AbstractNamedHighLevelNullData implements IEvent
{
    private RmDate $date;

    public function getNumberOfDays(): AbstractRmInt
    {
        return RmInt::new(1);
    }

    public function setDate(RmDate $date): IEvent
    {
        $this->date = $date;
        return $this;
    }

    public function getDate(): RmDate
    {
        return $this->date;
    }

    public function getVenueId(): AbstractRmInt
    {
        return RmNullInt::new(null);
    }

    public function getUrl(): AbstractRmString
    {
        return RmNullString::new(null);
    }
}
