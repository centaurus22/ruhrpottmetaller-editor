<?php

namespace ruhrpottmetaller\Data\LowLevel;

class RmString extends AbstractLowLevelDataObject
{
    public function get(): ?string
    {
        return $this->value;
    }

    public function concatWith(RmString $String): RmString
    {
        $this->value .= $String->get();
        return $this;
    }

    protected function convert($value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        return (string) $value;
    }
}
