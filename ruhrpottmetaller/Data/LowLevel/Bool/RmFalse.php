<?php

namespace ruhrpottmetaller\Data\LowLevel\Bool;

class RmFalse extends AbstractRmBool
{
    public function isTrue(): bool
    {
        return false;
    }

    public function isFalse(): bool
    {
        return true;
    }
}