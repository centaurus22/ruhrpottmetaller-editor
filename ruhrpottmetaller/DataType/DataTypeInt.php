<?php

namespace ruhrpottmetaller\DataType;

class DataTypeInt extends AbstractDataTypeValue
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

    public function asString(): DataTypeString
    {
        return new DataTypeString($this->value);
    }

    protected function convertInput($value): ?int
    {
        if (is_null($value)) {
            return null;
        }

        return (int) $value;
    }
}
