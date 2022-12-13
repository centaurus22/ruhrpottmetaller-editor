<?php

namespace ruhrpottmetaller\Data\LowLevel\Bool;

use ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

abstract class AbstractRmBool extends AbstractLowLevelData
{
    public static function new($value)
    {
        return self::createObject($value);
    }

    public function set($value)
    {
        return self::createObject($value);
    }

    public function get(): ?bool
    {
        return $this->value;
    }

    protected static function createObject($value)
    {
        if (is_null($value)) {
            return new RmNullBool(null);
        } elseif ((bool) $value === true) {
            return new RmTrue(true);
        } else {
            return new RmFalse(false);
        }
    }

    public function asTableInput(
        RmString $fieldName,
        RmString $description,
        RmInt $rowId
    ): RmString {
        $primitive = sprintf(
            $this->getTableInputFormatString(),
            $fieldName->get(),
            $rowId->get(),
            $this->value,
            $description
        );
        return RmString::new($primitive);
    }
}
