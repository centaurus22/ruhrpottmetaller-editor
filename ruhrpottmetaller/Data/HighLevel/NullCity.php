<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;

class NullCity extends AbstractHighLevelNullData implements IData
{
    public function getIsVisible(): AbstractRmBool
    {
        return RmBool::new(null);
    }
}
