<?php

namespace ruhrpottmetaller\Data\LowLevel;

use ruhrpottmetaller\Data\IDataObject;

class RmDate extends \DateTime implements IDataObject
{
    private bool $isNull;

    public function __construct(?string $value)
    {
        parent::__construct($value);
        $this->reactToInputValueType($value);
    }

    public function __toString()
    {
        if ($this->isNull) {
            return '';
        } else {
            return parent::format('Y-m-d');
        }
    }

    /**
     * @throws \Exception
     */
    public static function new(?string $value): RmDate
    {
        return new self($value);
    }

    public function set(?string $value): RmDate
    {
        parent::modify($value);
        $this->reactToInputValueType($value);
        return $this;
    }

    public function get(): ?string
    {
        if ($this->isNull) {
            return null;
        }

        return parent::format('Y-m-d');
    }

    private function reactToInputValueType(?string $value)
    {
        if (is_null($value)) {
            $this->isNull = true;
        } else {
            $this->reactToString($value);
        }
    }

    private function reactToString(string $value)
    {
        $this->isNull = false;
        parent::setTime('0', '0');
    }
}
