<?php

namespace ruhrpottmetaller\Datatype;

interface IDatatype
{
    public function __construct($value);
    public static function new($value): IDatatype;
}
