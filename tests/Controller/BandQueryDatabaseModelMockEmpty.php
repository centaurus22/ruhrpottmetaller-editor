<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\BandQueryModel;

class BandQueryDatabaseModelMockEmpty extends BandQueryModel
{
    public function getBands(): RmArray
    {
        return RmArray::new();
    }
}
