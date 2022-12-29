<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\QueryVenueModel;

class QueryVenueDatabaseModelMockEmpty extends QueryVenueModel
{
    public function getVenues(): RmArray
    {
        return RmArray::new();
    }
}
