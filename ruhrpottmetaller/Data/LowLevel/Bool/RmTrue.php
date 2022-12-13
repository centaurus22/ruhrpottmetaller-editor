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

    protected function getTableInputFormatString(): string
    {
        return '<label for="%1$s_%2$u" class="visually-hidden">%4$s</label>
            <select id="%1$s_%2$u" name="%1$s">
                <option value="1" selected="selected">yes</option>
                <option value="0">no</option>
            </select>';
    }
}
