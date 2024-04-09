<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Bool\{AbstractRmBool, RmBool};
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmNullString;

class NullCity extends AbstractNamedHighLevelNullData implements ICity, IData
{
    public function getIsVisible(): AbstractRmBool
    {
        return RmBool::new(null);
    }

    public function getFormattedName(): AbstractRmString
    {
        return RmNullString::new(null);
    }
}
