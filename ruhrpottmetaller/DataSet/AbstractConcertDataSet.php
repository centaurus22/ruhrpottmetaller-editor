<?php

namespace ruhrpottmetaller\DataSet;

use ruhrpottmetaller\DataType\DataTypeDate;

abstract class AbstractConcertDataSet extends AbstractEventDataSet
{
    protected DataTypeDate $Date;

    public function setDate(DataTypeDate $Date): void
    {
        $this->Date = $Date;
    }

    public function getDate(): DataTypeDate
    {
        return $this->Date;
    }
}
