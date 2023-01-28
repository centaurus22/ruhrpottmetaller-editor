<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\{ICity, City};
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class GigQueryModel extends AbstractQueryModel
{
    public static function new(?\mysqli $connection): GigQueryModel
    {
        return new static($connection);
    }

    public function getGigsByEventId(RmInt $eventId): RmArray
    {
        $query = 'SELECT band_id, additional_information FROM gig
                                       WHERE event_id = ? ORDER BY id';
        return $this->query($query, 'i', [$eventId->get()]);
    }

    protected function getDataFromResult(stdClass $object): ICity
    {
        return City::new();
    }
}
