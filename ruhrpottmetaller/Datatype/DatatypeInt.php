<?php

namespace ruhrpottmetaller\Datatype;

class DatatypeInt extends AbstractDatatypeValue
{
    protected ?int $value;

    public function __construct($value)
    {
        parent::__construct($value);
    }

    public function get(): ?int
    {
        return $this->value;
    }

    public function asString(): DatatypeString
    {
        return new DatatypeString($this->value);
    }

    protected function convertInput($value): ?int
    {
        if (is_null($value)) {
            return null;
        }

        return (int) $value;
    }
}
