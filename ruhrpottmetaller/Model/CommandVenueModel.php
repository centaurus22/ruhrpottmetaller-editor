<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\LowLevel\Bool\AbstractRmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;

class CommandVenueModel extends AbstractCommandModel
{
    public static function new(?\mysqli $connection): CommandVenueModel
    {
        return new static($connection);
    }

    public function updateVenue(
        RmInt $id,
        RmString $name,
        AbstractRmString $urlDefault,
        AbstractRmBool $isVisible
    ): void {
        $query = 'UPDATE venue SET name = ?, url_default = ?, is_visible = ? WHERE id = ?';
        $this->query(
            $query,
            'ssii',
            [$name->get(), $urlDefault->get(), $isVisible->get(), $id->get()]
        );
    }
}
