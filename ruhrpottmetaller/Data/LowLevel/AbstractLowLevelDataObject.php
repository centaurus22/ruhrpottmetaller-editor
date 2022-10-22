<?php

namespace ruhrpottmetaller\Data\LowLevel;

use ruhrpottmetaller\Data\IDataObject;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

abstract class AbstractLowLevelDataObject implements IDataObject
{
    protected $value;

    protected function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    public function asTableCell(): string
    {
        return RmString::new('<div class="rm_table_cell">' . $this->value . '</div>');
    }
}
