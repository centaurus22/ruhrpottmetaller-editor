<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\VenueQueryModel;

class VenueDatabaseQueryModelMockEmpty extends VenueQueryModel
{
    public function getVenues(): RmArray
    {
        return RmArray::new();
    }

    public function getVenuesByCityName(RmString $cityName): RmArray
    {
        return RmArray::new();
    }
}
