<?php

namespace ruhrpottmetaller\Variable;

interface IString
{
    public function setIt($value): void;
    public function getIt(): ?string;
    public function printIt(): void;
}
