<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\RmDate;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\QueryEventDatabaseModel;

class QueryEventDatabaseModelMockEmpty extends QueryEventDatabaseModel
{
    public function getEventsByMonth(RmDate $Month): RmArray
    {
        return RmArray::new();
    }
}
