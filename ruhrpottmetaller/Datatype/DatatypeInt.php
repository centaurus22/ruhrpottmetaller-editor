<?php

namespace ruhrpottmetaller\Datatype;

class DatatypeInt implements IDatatype
{
    private ?int $int;

    public function __construct($value)
    {
        $this->int = $this->convertInput($value);
    }

    public static function new($value): IDatatype
    {
        return new DatatypeInt($value);
    }

    public function get(): ?int
    {
        return $this->int;
    }

    public function set($value): IDatatype
    {
        $this->int = $this->convertInput($value);
        return $this;
    }

    public function print(): IDatatype
    {
        echo $this->int;
        return $this;
    }

    private function convertInput($value): ?int
    {
        if (is_null($value)) {
            return null;
        }

        return (int) $value;
    }
}
