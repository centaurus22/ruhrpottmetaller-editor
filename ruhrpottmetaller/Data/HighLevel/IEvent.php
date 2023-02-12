<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;

interface IEvent
{
    public function getId(): AbstractRmInt;
    public function getName(): AbstractRmString;
    public function getNumberOfDays(): AbstractRmInt;
    public function getDate(): RmDate;
    public function getUrl(): AbstractRmString;
}
