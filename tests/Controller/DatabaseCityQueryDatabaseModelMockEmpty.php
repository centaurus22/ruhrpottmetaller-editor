<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;

class DatabaseCityQueryDatabaseModelMockEmpty extends DatabaseCityQueryModel
{
    public function getCities(): RmArray
    {
        return RmArray::new();
    }

    public function getCitiesByFirstChar(RmString $firstChar): RmArray
    {
        return RmArray::new();
    }
}
