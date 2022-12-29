<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;

interface IVenue
{
    public function getId(): AbstractRmInt;
    public function getName(): AbstractRmString;
    public function getCityName(): AbstractRmString;
    public function getUrlDefault(): AbstractRmString;
    public function getIsVisible(): AbstractRmBool;
    public function asVenueAndCity(): AbstractRmString;
}
