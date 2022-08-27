<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject;
use ruhrpottmetaller\Data\LowLevel\RmString;

abstract class AbstractHighLevelDataObject extends AbstractRmObject implements IDataObject
{

    protected RmString $Name;
    protected AbstractLowLevelDataObject $Id;

    public function getId(): AbstractLowLevelDataObject
    {
        return $this->Id;
    }

    public function setId(AbstractLowLevelDataObject $Id): AbstractHighLevelDataObject
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