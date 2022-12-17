<?php

namespace ruhrpottmetaller\Data\LowLevel\String;

use ruhrpottmetaller\Data\LowLevel\Int\RmInt;

class RmString extends AbstractRmString
{
    public function asFirstUppercase(): RmString
    {
        return RmString::new(ucfirst($this->value));
    }

    public function asPrefixed(RmString $prefix): RmString
    {
        return RmString::new($prefix->concatWith($this));
    }
}
