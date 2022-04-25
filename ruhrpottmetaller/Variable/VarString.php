<?php

namespace ruhrpottmetaller\Variable;

class VarString implements IString
{
    private ?string $String;

    public function __construct($value)
    {
        $this->String = $this->convertInput($value);
    }

    public function getIt(): ?string
    {
        return $this->String;
    }

    public function setIt($value): void
    {
        $this->String = $this->convertInput($value);
    }

    public function printIt(): void
    {
        echo (string) $this->String;
    }

    private function convertInput($value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        return (string) $value;
    }
}
