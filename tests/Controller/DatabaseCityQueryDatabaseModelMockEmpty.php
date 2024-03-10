<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;

class DatabaseCityQueryDatabaseModelMockEmpty extends DatabaseCityQueryModel
{
    public function getCities(): RmArray
    {
        return RmArray::new();
    }

    public function getCitiesByFirstChar(AbstractRmString $firstChar): RmArray
    {
        return RmArray::new();
    }
}
