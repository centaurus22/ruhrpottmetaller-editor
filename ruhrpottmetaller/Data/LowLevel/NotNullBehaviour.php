<?php

namespace ruhrpottmetaller\Data\LowLevel;

class NotNullBehaviour implements INullBehaviour
{

    public function isNull(): bool
    {
        return false;
    }
}