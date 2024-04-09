<?php

namespace tests\ruhrpottmetaller\Controller;

use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use ruhrpottmetaller\Model\Query\DatabaseBandQueryModel;

class DatabaseBandQueryDatabaseModelMock extends DatabaseBandQueryModel
{
    public function getBands(): RmArray
    {
        $Band = Band::new()
            ->setId(RmInt::new('3'))
            ->setName(RmString::new('Wheel'))
            ->setIsVisible(RmBool::new(true));
        $Array = RmArray::new();
        return $Array->add($Band);
    }
}
