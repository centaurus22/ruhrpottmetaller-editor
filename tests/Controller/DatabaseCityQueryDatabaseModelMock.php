<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\Query\DatabaseCityQueryModel;

class DatabaseCityQueryDatabaseModelMock extends DatabaseCityQueryModel
{
    public function getCities(): RmArray
    {
        $City = City::new()
            ->setId(RmInt::new('3'))
            ->setName(RmString::new('Essen'))
            ->setIsVisible(RmBool::new(true));
        $Array = RmArray::new();
        return $Array->add($City);
    }
}
