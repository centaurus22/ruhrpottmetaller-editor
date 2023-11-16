<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;

class DatabaseBandQueryDatabaseModelMockEmpty extends DatabaseBandQueryModel
{
    public function getBands(): RmArray
    {
        return RmArray::new();
    }
}
