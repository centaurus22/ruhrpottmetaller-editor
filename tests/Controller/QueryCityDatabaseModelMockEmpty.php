<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\QueryCityDatabaseModel;

class QueryCityDatabaseModelMockEmpty extends QueryCityDatabaseModel
{
    public function getCities(): RmArray
    {
        return RmArray::new();
    }
}
