<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\Query\DatabaseVenueQueryModel;

class DatabaseVenueQueryDatabaseModelMockEmpty extends DatabaseVenueQueryModel
{
    public function getVenues(): RmArray
    {
        return RmArray::new();
    }

    public function getVenuesByCityName(AbstractRmString $cityName): RmArray
    {
        return RmArray::new();
    }
}
