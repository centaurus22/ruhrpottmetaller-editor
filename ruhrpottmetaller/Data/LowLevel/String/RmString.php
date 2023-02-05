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

    public function asSubmitButton(): RmString
    {
        return RmString::new('<button type="submit">' . $this->value . '</button>');
    }

    public function isEmpty(): bool
    {
        return $this->value == '';
    }
}
