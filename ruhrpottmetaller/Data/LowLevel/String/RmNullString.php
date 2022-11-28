<?php

namespace ruhrpottmetaller\Data\LowLevel\String;

class RmNullString extends AbstractRmString
{
    public function asFirstUppercase(): RmNullString
    {
        return RmNullString::new(null);
    }
}
