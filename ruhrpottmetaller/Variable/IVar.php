<?php

namespace ruhrpottmetaller\Variable;

interface IVar
{
    public function __construct($value);
    public static function new($value);
}
