<?php

namespace ruhrpottmetaller\Data\LowLevel\String;

class IsNullBehaviour implements INullBehaviour
{
    public function isNull(): bool
    {
        return true;
    }
}