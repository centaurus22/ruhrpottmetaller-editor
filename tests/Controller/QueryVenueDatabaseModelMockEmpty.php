<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\QueryVenueDatabaseModel;

class QueryVenueDatabaseModelMockEmpty extends QueryVenueDatabaseModel
{
    public function getVenues(): RmArray
    {
        return RmArray::new();
    }
}
