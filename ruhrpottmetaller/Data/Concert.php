<?php

namespace ruhrpottmetaller\Data;

use ruhrpottmetaller\DataType\DataTypeDate;

class Concert extends AbstractEvent
{
    protected DataTypeDate $Date;

    public function setDate(DataTypeDate $Date): Concert
    {
        $this->Date = $Date;
        return $this;
    }

    public function getDate(): DataTypeDate
    {
        return $this->Date;
    }
}
