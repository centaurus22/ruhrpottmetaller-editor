<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;

class NullEvent extends AbstractNamedHighLevelNullData implements IEvent
{
    public function getNumberOfDays(): AbstractRmInt
    {
        return RmInt::new(1);
    }
}
