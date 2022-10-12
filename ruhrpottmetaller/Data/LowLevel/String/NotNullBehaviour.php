<?php

namespace ruhrpottmetaller\Data\LowLevel\String;

class NotNullBehaviour implements INullBehaviour
{

    public function isNull(): bool
    {
        return false;
    }
}