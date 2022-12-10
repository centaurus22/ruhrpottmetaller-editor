<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\{IVenue, Venue, NullVenue};
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\{AbstractRmInt, RmInt};
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class QueryVenueDatabaseModel extends AbstractDatabaseModel
{
    private QueryCityDatabaseModel $queryCityDatabaseModel;

    public function __construct(
        ?\mysqli $connection,
        QueryCityDatabaseModel $queryCityDatabaseModel
    ) {
        parent::__construct(
            $this->connection = $connection,
        );
        $this->queryCityDatabaseModel = $queryCityDatabaseModel;
    }

    public static function new(
        ?\mysqli $connection,
        QueryCityDatabaseModel $queryCityDatabaseModel
    ) {
        return new static($connection, $queryCityDatabaseModel);
    }

    public function getVenues(): RmArray
    {
        $query = 'SELECT id, name, city_id, is_visible FROM venue ORDER BY name';
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        $array = RmArray::new();
        while ($object = $result->fetch_object()) {
            $array->add($this->getVenueFromDatabaseResult($object));
        }
        return $array;
    }

    public function getVenueById(AbstractRmInt $venueId): IVenue
    {
        if ($venueId->isNull()) {
            return NullVenue::new();
        }

        $query = 'SELECT id, name, city_id, is_visible FROM venue WHERE id = ?';
        $statement = $this->connection->prepare($query);
        $venueIdSql = $venueId->get();
        $statement->bind_param('i', $venueIdSql);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $this->getVenueFromDatabaseResult($result->fetch_object());
    }

    private function getVenueFromDatabaseResult(stdClass $object): Venue
    {
        $city = $this->queryCityDatabaseModel
            ->getCityById(RmInt::new($object->city_id));
        return Venue::new()
            ->setId(RmInt::new($object->id))
            ->setName(RmString::new($object->name))
            ->setCity($city)
            ->setIsVisible(RmBool::new($object->is_visible));
    }
}
