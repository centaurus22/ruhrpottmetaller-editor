<?php

namespace ruhrpottmetaller\Data\LowLevel;

use ruhrpottmetaller\Data\IData;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

abstract class AbstractLowLevelData implements IData
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

    public function asTableCell(): RmString
    {
        return RmString::new('<div class="rm_table_cell">' . $this->value . '</div>');
    }

    public function asHiddenTableInput(RmString $fieldName, RmInt $rowId): RmString
    {
        $format = '<input type="hidden" id="%1$s_%2$s" name="%1$s" value="%3$s">';
        return RmString::new(sprintf($format, $fieldName->get(), $rowId->get(), $this->value));
    }
}
