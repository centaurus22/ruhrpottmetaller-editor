<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Bool\RmNullBool;
use ruhrpottmetaller\Data\LowLevel\String\{RmString, RmNullString};

class NullVenue extends AbstractHighLevelNullData implements IData, IVenue
{
    public function getCity(): NullCity
    {
        return NullCity::new();
    }

    public function getUrlDefault(): RmNullString
    {
        return RmNullString::new(null);
    }

    public function getIsVisible(): RmNullBool
    {
        return RmNullBool::new(null);
    }

    public function asVenueAndCity(): RmNullString
    {
        return RmString::new(null);
    }
}
