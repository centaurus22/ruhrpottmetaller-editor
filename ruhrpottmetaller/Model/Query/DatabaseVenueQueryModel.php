<?php

namespace ruhrpottmetaller\Model\Query;

use ruhrpottmetaller\Data\HighLevel\{IVenue, NullVenue, Venue};
use mysqli;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\{AbstractRmInt, RmInt};
use ruhrpottmetaller\Data\LowLevel\String\AbstractRmString;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class DatabaseVenueQueryModel extends DatabaseQueryModel
{
    private DatabaseCityQueryModel $queryCityModel;

    public function __construct(
        ?mysqli                $connection,
        DatabaseCityQueryModel $queryCityModel
    ) {
        parent::__construct($this->connection = $connection);
        $this->queryCityModel = $queryCityModel;
    }

    public static function new(
        ?mysqli                $connection,
        DatabaseCityQueryModel $queryCityModel
    ): DatabaseVenueQueryModel {
        return new static($connection, $queryCityModel);
    }

    public function getVenues(): RmArray
    {
        $query = 'SELECT id, name, city_id, url_default, is_visible FROM venue ORDER BY name';
        return $this->query($query);
    }

    public function getVenuesByCityName(AbstractRmString $cityName): RmArray
    {
        $query = 'SELECT 
                venue.id AS id,
                venue.name AS name,
                city_id,
                url_default,
                venue.is_visible AS is_visible
            FROM venue
            JOIN city ON venue.city_id = city.id
            WHERE city.name LIKE ?
            ORDER BY name';
        return $this->query($query, 's', [$cityName->get()]);
    }

    public function getVenuesByCityId(AbstractRmInt $cityId): RmArray
    {
        $query = 'SELECT 
                venue.id AS id,
                venue.name AS name,
                city_id,
                url_default,
                venue.is_visible AS is_visible
            FROM venue
            WHERE city_id LIKE ?
            ORDER BY name';
        return $this->query($query, 'i', [$cityId->get()]);
    }

    public function getVenueById(AbstractRmInt $venueId): IVenue
    {
        if ($venueId->isNull()) {
            return NullVenue::new();
        }

        $query = 'SELECT id, name, city_id, url_default, is_visible FROM venue WHERE id = ?';
        return $this->queryOne($query, 'i', [$venueId->get()]);
    }


    public function getVenueByVenueData(Venue $venue): Venue
    {
        $query = 'SELECT id, name, city_id, url_default, is_visible FROM venue
            WHERE name = ? AND city_id = ?';
        return $this->queryOne(
            $query,
            'si',
            [$venue->getName()->get(), $venue->getCityId()->get()]
        );
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
