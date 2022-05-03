<?php

namespace ruhrpottmetaller\Controller;

abstract class AbstractEventController
{
    protected \ruhrpottmetaller\DataType\DataTypeInt $id;

    public static function new()
    {
        return new static();
    }

    public function setId(\ruhrpottmetaller\DataType\DataTypeInt $id): void
    {
        $this->id = $id;
    }

    public function getId(): \ruhrpottmetaller\DataType\DataTypeInt
    {
        return $this->id;
    }

}
