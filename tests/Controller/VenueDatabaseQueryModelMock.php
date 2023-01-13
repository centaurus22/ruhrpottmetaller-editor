<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\VenueQueryModel;

class VenueDatabaseQueryModelMock extends VenueQueryModel
{
    public function getVenues(): RmArray
    {
        $city = City::new()
            ->setId(RmInt::new('3'))
            ->setName(RmString::new('Essen'))
            ->setIsVisible(RmBool::new(true));
        $venue  = Venue::new()
            ->setId(RmInt::new('2'))
            ->setName(RmString::new('Turock'))
            ->setCity($city)
            ->setIsVisible(RmBool::new(true));
        $Array = RmArray::new();
        return $Array->add($venue);
    }
}
