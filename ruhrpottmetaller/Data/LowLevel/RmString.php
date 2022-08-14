<?php

namespace ruhrpottmetaller\Data\LowLevel;

class RmString extends AbstractRmValue
{
    protected $value;

    public function __construct($value)
    {
        parent::__construct($value);
    }

    public function get(): ?string
    {
        return $this->value;
    }

    protected function convert($value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        return (string) $value;
    }
}
