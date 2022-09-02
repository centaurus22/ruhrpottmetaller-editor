<?php

namespace ruhrpottmetaller\Data\LowLevel;

class RmInt extends AbstractLowLevelDataObject
{
    public function get(): ?int
    {
        return $this->value;
    }

    public function asString(): RmString
    {
        return new RmString($this->value);
    }

    protected function convert($value): ?int
    {
        if (is_null($value)) {
            return null;
        }

        return (int) $value;
    }
}
