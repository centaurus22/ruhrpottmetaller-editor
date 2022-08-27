<?php

namespace ruhrpottmetaller;

class AbstractRmObject
{
    public static function new()
    {
        return new static();
    }
}