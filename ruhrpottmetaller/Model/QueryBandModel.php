<?php

namespace ruhrpottmetaller\Model;

use ruhrpottmetaller\Data\HighLevel\Band;
use ruhrpottmetaller\Data\LowLevel\{Bool\RmBool, Int\RmInt, String\RmString};
use ruhrpottmetaller\Data\RmArray;
use stdClass;

class QueryBandModel extends AbstractModel
{
    public static function new(?\mysqli $connection)
    {
        return new static($connection);
    }

    public function getBands(): RmArray
    {
        $query = 'SELECT id, name, is_visible FROM band ORDER BY name';
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();

        $array = RmArray::new();
        while ($object = $result->fetch_object()) {
            $array->add($this->getBandFromDatabaseResult($object));
        }
        return $array;
    }

    private function getBandFromDatabaseResult(stdClass $object): Band
    {
        return Band::new()
            ->setId(RmInt::new($object->id))
            ->setName(RmString::new($object->name))
            ->setIsVisible(RmBool::new($object->is_visible));
    }
}
