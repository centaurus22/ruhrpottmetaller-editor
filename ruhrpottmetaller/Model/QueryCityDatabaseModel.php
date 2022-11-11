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
    /**
     * @throws \Exception
     */
    public function getCities(): RmArray
    {
        $query = 'SELECT id, name, is_visible FROM city';
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        while ($object = $result->fetch_object()) {
            $this->array->add($this->getCityFromDatabaseResult($object));
        }
        return $this->array;
    }

    private function getCityFromDatabaseResult(stdClass $object): City
    {
        return City::new()
            ->setId(RmInt::new($object->id))
            ->setName(RmString::new($object->name))
            ->setIsVisible(RmBool::new($object->is_visible));
    }
}
