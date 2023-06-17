<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\DatabaseBandQueryModel;

class DatabaseBandQueryDatabaseModelMockEmpty extends DatabaseBandQueryModel
{
    public function getBands(): RmArray
    {
        return RmArray::new();
    }
}
