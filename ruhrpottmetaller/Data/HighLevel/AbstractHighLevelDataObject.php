<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;

abstract class AbstractHighLevelDataObject extends AbstractRmObject implements IDataObject
{

    protected AbstractRmString $Name;
    protected AbstractRmInt $Id;

    public function getId(): AbstractRmInt
    {
        return $this->Id;
    }

    public function setId(AbstractRmInt $Id): AbstractHighLevelDataObject
    {
        $this->Id = $Id;
        return $this;
    }

    public function setName(AbstractRmString $Name): AbstractHighLevelDataObject
    {
        $this->Name = $Name;
        return $this;
    }

    public function getName(): AbstractRmString
    {
        return $this->Name;
    }
}