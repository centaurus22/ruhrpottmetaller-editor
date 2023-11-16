<?php

namespace ruhrpottmetaller\Model\Command;

use mysqli;
use ruhrpottmetaller\Data\HighLevel\Venue;

class DatabaseVenueCommandModel extends DatabaseCommandModel
{
    public static function new(?mysqli $connection): DatabaseVenueCommandModel
    {
        return new static($connection);
    }

    public function addVenue(Venue $venue): void
    {
        $query = 'INSERT INTO venue SET name = ?, city_id = ?, url_default = ?, is_visible = ?';
        $this->query(
            $query,
            'sisi',
            [
                $venue->getName()->get(),
                $venue->getCityId()->get(),
                $venue->getUrlDefault()->get(),
                $venue->getIsVisible()->get(),
            ]
        );
    }

    public function replaceData(Venue $venue): void
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
