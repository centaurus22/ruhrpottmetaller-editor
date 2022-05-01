<?php

namespace ruhrpottmetaller\DataType;

class DataTypeString extends AbstractDataTypeValue
{
    protected ?string $value;

    public function __construct($value)
    {
        parent::__construct($value);
    }

    public function get(): ?string
    {
        return $this->value;
    }

    protected function convertInput($value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        return (string) $value;
    }
}
