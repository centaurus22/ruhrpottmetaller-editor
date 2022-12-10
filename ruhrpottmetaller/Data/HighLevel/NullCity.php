<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Bool\{AbstractRmBool, RmBool};

class NullCity extends AbstractHighLevelNullData implements ICity, IData
{
    public function getIsVisible(): AbstractRmBool
    {
        return RmBool::new(null);
    }
}
