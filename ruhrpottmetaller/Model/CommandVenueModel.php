<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\Venue;

class CommandVenueModel extends AbstractCommandModel
{
    public static function new(?\mysqli $connection): CommandVenueModel
    {
        return new static($connection);
    }

    public function updateVenue(Venue $venue): void
    {
        $query = 'UPDATE venue SET name = ?, url_default = ?, is_visible = ? WHERE id = ?';
        $this->query(
            $query,
            'ssii',
            [
                $venue->getName()->get(),
                $venue->getUrlDefault()->get(),
                $venue->getIsVisible()->get(),
                $venue->getId()->get()
            ]
        );
    }
}
