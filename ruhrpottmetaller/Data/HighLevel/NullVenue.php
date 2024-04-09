<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Bool\RmNullBool;
use ruhrpottmetaller\Data\LowLevel\String\{RmString, RmNullString};
use ruhrpottmetaller\Data\LowLevel\Int\RmNullInt;

class NullVenue extends AbstractNamedHighLevelNullData implements IData, IVenue
{
    public function getCityName(): RmNullString
    {
        return RmNullString::new(null);
    }

    public function getCityId(): RmNullInt
    {
        return RmNullInt::new(null);
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

    public function asFormattedVenueAndCity(): RmNullString
    {
        return RmNullString::new(null);
    }
}
