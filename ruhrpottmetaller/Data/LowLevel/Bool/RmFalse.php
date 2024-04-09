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

    protected function getTableInputFormatString(): string
    {
        return '<label for="%1$s_%2$u" class="visually-hidden">%4$s</label>
            <select id="%1$s_%2$u" name="%1$s">
                <option value="1">yes</option>
                <option value="0" selected="selected">no</option>
            </select>';
    }
}
