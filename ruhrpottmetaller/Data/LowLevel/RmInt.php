<?php

namespace ruhrpottmetaller\Data\LowLevel;

class RmInt extends AbstractRmValue
{
    protected $value;

    public function __construct($value)
    {
        parent::__construct($value);
    }

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
