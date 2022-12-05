<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\HighLevel\Venue;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
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

    /**
     * @throws \Exception
     */
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

    private function getVenueFromDatabaseResult(stdClass $object): Venue
    {
        return Venue::new()
            ->setId(RmInt::new($object->id))
            ->setName(RmString::new($object->name))
            ->setCity($this->getCity(RmInt::new($object->city_id)))
            ->setIsVisible(RmBool::new($object->is_visible));
    }

    private function getCity(RmInt $cityId): City
    {
        return $this->queryCityDatabaseModel->getCityById($cityId)->getCurrent();
    }
}
