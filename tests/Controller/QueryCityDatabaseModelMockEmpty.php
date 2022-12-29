<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\QueryCityModel;

class QueryCityDatabaseModelMockEmpty extends QueryCityModel
{
    public function getCities(): RmArray
    {
        return RmArray::new();
    }
}
