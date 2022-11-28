<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\QueryBandDatabaseModel;

class QueryBandDatabaseModelMockEmpty extends QueryBandDatabaseModel
{
    public function getBands(): RmArray
    {
        return RmArray::new();
    }
}
