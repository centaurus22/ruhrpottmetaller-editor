<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;

abstract class AbstractHighLevelDataObject extends AbstractRmObject implements IDataObject
{

    protected AbstractRmString $name;
    protected AbstractRmInt $id;

    public function getId(): AbstractRmInt
    {
        return $this->id;
    }

    public function setId(AbstractRmInt $id): AbstractHighLevelDataObject
    {
        $this->id = $id;
        return $this;
    }

    public function setName(AbstractRmString $name): AbstractHighLevelDataObject
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): AbstractRmString
    {
        return $this->name;
    }
}