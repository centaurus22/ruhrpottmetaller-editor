<?php

namespace ruhrpottmetaller\Datatype;

class DatatypeString implements IDatatype
{
    private ?string $String;

    public function __construct($value)
    {
        $this->String = $this->convertInput($value);
    }

    public static function new($value): IDatatype
    {
        return new DatatypeString($value);
    }

    public function get(): ?string
    {
        return $this->String;
    }

    public function set($value): IDatatype
    {
        $this->String = $this->convertInput($value);
        return $this;
    }

    public function print(): IDatatype
    {
        echo $this->String;
        return $this;
    }

    private function convertInput($value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        return (string) $value;
    }
}
