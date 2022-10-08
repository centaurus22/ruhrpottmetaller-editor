<?php

namespace ruhrpottmetaller\Data\LowLevel;

class IsNullBehaviour implements INullBehaviour
{
    public function isNull(): bool
    {
        return true;
    }
}