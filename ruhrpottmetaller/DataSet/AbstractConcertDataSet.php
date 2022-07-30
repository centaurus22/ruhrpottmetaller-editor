<?php

namespace ruhrpottmetaller\DataSet;

use ruhrpottmetaller\DataType\DataTypeDate;

abstract class AbstractConcertDataSet extends AbstractEventDataSet
{
    protected DataTypeDate $Date;

    public function setDate(DataTypeDate $Date): AbstractConcertDataSet
    {
        $this->Date = $Date;
        return $this;
    }

    public function getDate(): DataTypeDate
    {
        return $this->Date;
    }
}
