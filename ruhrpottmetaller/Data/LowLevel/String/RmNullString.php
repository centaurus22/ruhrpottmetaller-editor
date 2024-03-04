<?php

namespace ruhrpottmetaller\Data\LowLevel\String;

class RmNullString extends AbstractRmString
{
    public function asFirstUppercase(): RmNullString
    {
        return RmNullString::new(null);
    }
    public function asPrefixedWidth(RmString $prefix): RmNullString
    {
        return RmNullString::new(null);
    }

    public function isEmpty(): bool
    {
        return true;
    }

    protected function filter(): RmNullString
    {
        return $this;
    }
}
