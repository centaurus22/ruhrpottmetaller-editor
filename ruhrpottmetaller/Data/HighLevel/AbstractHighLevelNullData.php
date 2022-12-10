<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

abstract class AbstractHighLevelNullData extends AbstractRmObject implements IData
{
    public function getId(): AbstractRmInt
    {
        return RmInt::new(null);
    }

    public function getName(): AbstractRmString
    {
        return RmString::new(null);
    }
}
