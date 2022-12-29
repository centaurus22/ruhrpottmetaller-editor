<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\QueryBandModel;

class QueryBandDatabaseModelMockEmpty extends QueryBandModel
{
    public function getBands(): RmArray
    {
        return RmArray::new();
    }
}
