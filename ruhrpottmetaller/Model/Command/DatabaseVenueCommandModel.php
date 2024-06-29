<?php

namespace ruhrpottmetaller\Model\Command;

use mysqli;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;

class DatabaseVenueCommandModel extends DatabaseCommandModel
{
    public static function new(?mysqli $connection): DatabaseVenueCommandModel
    {
        return new static($connection);
    }

    public function addVenue(Venue $venue): RmInt
    {
        $query = 'INSERT INTO venue SET name = ?, city_id = ?, url_default = ?';
        $this->query(
            $query,
            'sis',
            [
                $venue->getName()->get(),
                $venue->getCityId()->get(),
                $venue->getUrlDefault()->get(),
            ]
        );
        return $this->getLastInsertedId();
    }

    public function replaceData(Venue $venue): void
    {
        $query = 'UPDATE venue SET name = ?, url_default = ?, is_visible = ? WHERE id = ?';
        $this->query( $query,'ssii', [
                $venue->getName()->get(),
                $venue->getUrlDefault()->get(),
                $venue->getIsVisible()->get(),
                $venue->getId()->get()
        ]);
    }
}
