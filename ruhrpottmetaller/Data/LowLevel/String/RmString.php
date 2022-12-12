<?php

namespace ruhrpottmetaller\Data\LowLevel\String;

use ruhrpottmetaller\Data\LowLevel\Int\RmInt;

class RmString extends AbstractRmString
{
    public function asFirstUppercase(): RmString
    {
        return RmString::new(ucfirst($this->value));
    }

    public function asTableInput(RmString $fieldName, RmInt $rowId): RmString
    {
        $format = '<label for="%1$s_%2$u" class="visually-hidden">%4$s</label>
            <input id="%1$s_%2$u" name="%1$s" value="%3$s" placeholder="%4$s">';
        $primitive = sprintf(
            $format,
            $fieldName->get(),
            $rowId->get(),
            $this->value,
            $fieldName->asFirstUppercase()->get()
        );
        return RmString::new($primitive);
    }
}
