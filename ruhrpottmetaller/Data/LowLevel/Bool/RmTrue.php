<?php

namespace ruhrpottmetaller\Data\LowLevel\Bool;

class RmTrue extends AbstractRmBool
{
    public function isTrue(): bool
    {
        return true;
    }

    public function isFalse(): bool
    {
        return false;
    }
}