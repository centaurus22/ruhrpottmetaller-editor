<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\LowLevel\Date\RmDate;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\QueryEventModel;

class QueryEventDatabaseModelMockEmpty extends QueryEventModel
{
    public function getEventsByMonth(RmDate $month): RmArray
    {
        return RmArray::new();
    }
}
