<?php

namespace ruhrpottmetaller\Data\HighLevel;

use ruhrpottmetaller\AbstractRmObject;
use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Int\AbstractRmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;

abstract class AbstractHighLevelData extends AbstractRmObject implements IData
{
    protected AbstractRmString $name;
    protected AbstractRmInt $id;

    public function getId(): AbstractRmInt
    {
        return $this->id;
    }

    public function setId(AbstractRmInt $id): AbstractHighLevelData
    {
        $this->id = $id;
        return $this;
    }

    public function setName(AbstractRmString $name): AbstractHighLevelData
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): AbstractRmString
    {
        return $this->name;
    }
}
