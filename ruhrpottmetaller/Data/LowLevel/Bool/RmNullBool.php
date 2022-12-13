<?php

namespace ruhrpottmetaller\Data\LowLevel\Bool;

class RmNullBool extends AbstractRmBool
{
    protected function getTableInputFormatString(): string
    {
        return '<label for="%1$s_%2$u" class="visually-hidden">%4$s</label>
            <select id="%1$s_%2$u" name="%1$s">
                <option value="" selected="selected"></option>
                <option value="1">yes</option>
                <option value="0">no</option>
            </select>';
    }
}
