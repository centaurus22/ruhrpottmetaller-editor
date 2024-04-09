<?php

namespace ruhrpottmetaller\Factories;

abstract class AbstractFactory
{
    protected \mysqli $connection;

    public static function new(\mysqli $connection): AbstractFactory
    {
        return new static($connection);
    }
}
