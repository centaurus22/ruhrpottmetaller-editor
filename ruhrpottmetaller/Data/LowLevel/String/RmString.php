<?php

namespace ruhrpottmetaller\Data\LowLevel\String;

class RmString extends AbstractRmString
{
    public function asFirstUppercase(): RmString
    {
        return RmString::new(ucfirst($this->value));
    }

    public function asPrefixedWidth(RmString $prefix): RmString
    {
        return RmString::new($prefix->concatWith($this));
    }
}
