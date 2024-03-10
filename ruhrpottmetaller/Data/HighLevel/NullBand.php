<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Bool\RmTrue;

class NullBand extends AbstractNamedHighLevelNullData implements IData, IBand
{
    public function getIsVisible(): AbstractRmBool
    {
        return RmTrue::new(true);
    }
}
