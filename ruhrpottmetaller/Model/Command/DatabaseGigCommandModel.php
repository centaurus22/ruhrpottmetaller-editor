<?php

namespace ruhrpottmetaller\Model\Command;

use mysqli;
use ruhrpottmetaller\Data\HighLevel\Gig;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;

class DatabaseGigCommandModel extends DatabaseCommandModel
{
    public static function new(?mysqli $connection): DatabaseGigCommandModel
    {
        return new static($connection);
    }

    public function addGig(Gig $gig): RmInt
    {
        $query = 'INSERT INTO gig SET event_id = ?, band_id = ?, additional_information = ?';
        $this->query(
            $query,
            'iis',
            [$gig->getEventId()->get(), $gig->getBandId()->get(), $gig->getAdditionalInformation()]
        );
    }

    public function deleteGigs(Gig $gig): void
    {
        $query = 'DELETE FROM gig WHERE event_id = ?';
        $this->query(
            $query,
            'i',
            [$gig->getEventId()->get()]
        );
    }
}
