<?php

namespace ruhrpottmetaller\Data\LowLevel;

use ruhrpottmetaller\Data\IData;
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

    public function asHiddenInput(RmString $fieldName): RmString
    {
        $format = '<input type="hidden" name="%1$s" value="%2$s">';
        return RmString::new(sprintf($format, $fieldName->get(), $this->value));
    }
}
