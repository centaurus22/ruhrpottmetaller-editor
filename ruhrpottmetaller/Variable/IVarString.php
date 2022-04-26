<?php

namespace ruhrpottmetaller\Variable;

interface IVarString
{
    public function set($value): IVarString;
    public function get(): ?string;
    public function print(): IVarString;
}
