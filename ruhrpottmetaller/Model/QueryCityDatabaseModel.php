<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\City;
use ruhrpottmetaller\Data\LowLevel\Bool\RmBool;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\String\RmString;
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class QueryCityDatabaseModel extends AbstractDatabaseModel
{
    public static function new(?\mysqli $connection)
    {
        return new static($connection);
    }

    /**
     * @throws \Exception
     */
    public function getCities(): RmArray
    {
        $query = 'SELECT id, name, is_visible FROM city ORDER BY name';
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        $array = RmArray::new();
        while ($object = $result->fetch_object()) {
            $array->add($this->getCityFromDatabaseResult($object));
        }
        return $array;
    }



    public function getCityById(RmInt $cityId): RmArray
    {
        $query = 'SELECT id, name, is_visible FROM city WHERE id = ?';
        $statement = $this->connection->prepare($query);
        $cityIdSql = $cityId->get();
        $statement->bind_param('i', $cityIdSql);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        $array = RmArray::new();
        return $array->add($this->getCityFromDatabaseResult($result->fetch_object()));
    }

    private function getCityFromDatabaseResult(stdClass $object): City
    {
        return City::new()
            ->setId(RmInt::new($object->id))
            ->setName(RmString::new($object->name))
            ->setIsVisible(RmBool::new($object->is_visible));
    }
}
