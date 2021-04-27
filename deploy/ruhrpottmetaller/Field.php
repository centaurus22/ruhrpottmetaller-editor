<?php

namespace ruhrpottmetaller;

class Field
{
    private mixed $value = null;
    private string $description = "";

    public function __construct(mixed $value, string $description)
    {
        $this->value = $value;
        $this->description = $description;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}