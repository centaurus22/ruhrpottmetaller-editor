<?php

namespace ruhrpottmetaller\Data\LowLevel;

class RmBool extends AbstractRmValue
{
    protected $value;

    public function __construct($value)
    {
        parent::__construct($value);
    }

    public function get(): ?bool
    {
        return $this->value;
    }

    protected function convert($value): ?bool
    {
        if (is_null($value)) {
            return null;
        }

        return (bool) $value;
    }
}
