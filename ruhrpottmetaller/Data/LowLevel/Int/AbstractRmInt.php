<?php

namespace ruhrpottmetaller\Data\LowLevel\Int;

use ruhrpottmetaller\Data\LowLevel\{
    AbstractLowLevelData,
    INullBehaviour,
    IsNullBehaviour,
    NotNullBehaviour
};
use ruhrpottmetaller\Data\LowLevel\String\{AbstractRmString, RmString};

abstract class AbstractRmInt extends AbstractLowLevelData
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

    public function get(): ?int
    {
        return $this->value;
    }

    public function asString(): AbstractRmString
    {
        return RmString::new($this->value);
    }

    public function set($value)
    {
        return self::createObject($value);
    }

    public function isNull(): bool
    {
        return $this->nullBehaviour->isNull();
    }

    protected static function createObject($value)
    {
        if (is_null($value)) {
            return new RmNullInt(null, new IsNullBehaviour());
        }

        return new RmInt((int) $value, new NotNullBehaviour());
    }
}
