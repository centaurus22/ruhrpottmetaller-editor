<?php

namespace ruhrpottmetaller\Data\LowLevel\String;

use ruhrpottmetaller\Data\LowLevel\AbstractLowLevelDataObject;

abstract class AbstractRmString extends AbstractLowLevelDataObject
{
    protected INullBehaviour $nullBehaviour;

    protected function __construct($value, INullBehaviour $nullBehaviour)
    {
        $this->nullBehaviour = $nullBehaviour;
        parent::__construct($value);
    }

    public static function new($value)
    {
        return self::createObject($value);
    }

    public function set($value)
    {
        return self::createObject($value);
    }

    public function get(): ?string
    {
        return $this->value;
    }

    public function isNull(): bool
    {
        return $this->nullBehaviour->isNull();
    }

    public function concatWith(AbstractRmString $String): AbstractRmString
    {
        $this->value .= $String->get();
        return $this;
    }

    protected static function createObject($value)
    {
        if (is_null($value)) {
            return new RmNullString(null, new IsNullBehaviour());
        }

        return new RmString($value, new NotNullBehaviour());
    }
}