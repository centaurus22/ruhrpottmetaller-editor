<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\RmArray;

interface IEvent extends IData
{
    public function getId(): AbstractRmInt;
    public function getName(): AbstractRmString;
    public function getNumberOfDays(): AbstractRmInt;
    public function getDate(): RmDate;
    public function getVenueId(): AbstractRmInt;
    public function getCityId(): AbstractRmInt;
    public function getUrl(): AbstractRmString;

    public function getGigs(): RmArray;
}
