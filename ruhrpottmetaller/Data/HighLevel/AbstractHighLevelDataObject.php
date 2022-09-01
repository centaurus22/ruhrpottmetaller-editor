<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\RmInt;
use ruhrpottmetaller\Data\LowLevel\RmString;

abstract class AbstractHighLevelDataObject extends AbstractRmObject implements IDataObject
{

    protected RmString $Name;
    protected RmInt $Id;

    public function getId(): RmInt
    {
        return $this->Id;
    }

    public function setId(RmInt $Id): AbstractHighLevelDataObject
    {
        $this->Id = $Id;
        return $this;
    }

    public function setName(RmString $Name): AbstractHighLevelDataObject
    {
        $this->Name = $Name;
        return $this;
    }

    public function getName(): RmString
    {
        return $this->Name;
    }
}