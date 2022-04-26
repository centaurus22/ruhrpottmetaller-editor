<?php

namespace ruhrpottmetaller\Variable;

class VarString implements IVar, IVarString
{
    private ?string $String;

    public function __construct($value)
    {
        $this->String = $this->convertInput($value);
    }

    public static function new($value)
    {
        return new VarString($value);
    }

    public function get(): ?string
    {
        return $this->String;
    }

    public function set($value): IVarString
    {
        $this->String = $this->convertInput($value);
        return $this;
    }

    public function print(): IVarString
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
