<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\CityQueryModel;

class CityQueryDatabaseModelMockEmpty extends CityQueryModel
{
    public function getCities(): RmArray
    {
        return RmArray::new();
    }
}
