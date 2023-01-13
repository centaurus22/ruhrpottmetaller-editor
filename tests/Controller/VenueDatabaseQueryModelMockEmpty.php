<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\VenueQueryModel;

class VenueDatabaseQueryModelMockEmpty extends VenueQueryModel
{
    public function getVenues(): RmArray
    {
        return RmArray::new();
    }
}
