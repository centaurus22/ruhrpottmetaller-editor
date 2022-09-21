<?php

namespace ruhrpottmetaller\Data\LowLevel;

abstract class AbstractRmString extends AbstractLowLevelDataObject
{
    public static function new($value): AbstractRmString
    {
        return self::createObject($value);
    }

    public function set($value): AbstractRmString
    {
        return self::createObject($value);
    }

    public function get(): ?string
    {
        return $this->value;
    }

    public function concatWith(AbstractRmString $String): AbstractRmString
    {
        $this->value .= $String->get();
        return $this;
    }

    protected static function createObject($value): AbstractRmString
    {
        if (is_null($value)) {
            return new RmNullString(null);
        }

        return new RmString($value);
    }

}
