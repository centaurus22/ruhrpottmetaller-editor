<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\{IVenue, Venue, NullVenue};
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\{AbstractRmInt, RmInt};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class VenueQueryModel extends AbstractQueryModel
{
    private CityQueryModel $queryCityModel;

    public function __construct(
        ?\mysqli $connection,
        CityQueryModel $queryCityModel
    ) {
        parent::__construct($this->connection = $connection);
        $this->queryCityModel = $queryCityModel;
    }

    public static function new(
        ?\mysqli $connection,
        CityQueryModel $queryCityModel
    ) {
        return new static($connection, $queryCityModel);
    }

    public function getVenues(): RmArray
    {
        $query = 'SELECT id, name, city_id, url_default, is_visible FROM venue ORDER BY name';
        return $this->query($query);
    }

    public function getVenueById(AbstractRmInt $venueId): IVenue
    {
        if ($venueId->isNull()) {
            return NullVenue::new();
        }

        $query = 'SELECT id, name, city_id, url_default, is_visible FROM venue WHERE id = ?';
        return $this->queryOne($query, 'i', [$venueId->get()]);
    }

    protected function getDataFromResult(stdClass $object): Venue
    {
        $city = $this->queryCityModel
            ->getCityById(RmInt::new($object->city_id));
        return Venue::new()
            ->setId(RmInt::new($object->id))
            ->setName(RmString::new($object->name))
            ->setCity($city)
            ->setUrlDefault(RmString::new($object->url_default))
            ->setIsVisible(RmBool::new($object->is_visible));
    }
}
