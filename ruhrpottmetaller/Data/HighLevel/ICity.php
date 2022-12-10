<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;

interface ICity
{
    public function getId(): AbstractRmInt;
    public function getName(): AbstractRmString;
    public function getIsVisible(): AbstractRmBool;
}
